// google c&p coding is the best

function bonzoInit(element, source, images) {

    // preprocess the source
    source = source.split("sampler1D").join("sampler2D");
    let lines = source.split("\n");
    if (lines[0].startsWith("#version"))
        lines.splice(0,1);

    lines.splice(0,0,"#version 300 es","precision mediump float;");
    source = lines.join("\n");

    // create the canvas
    const canvas = document.createElement("CANVAS");
    canvas.width = element.clientWidth;
    canvas.height = element.clientHeight;
    element.appendChild(canvas);

    // Initialize the GL context
    const gl = canvas.getContext("webgl2");

    // Only continue if WebGL is available and working
    if (gl === null) {     
        alert('Could not initialize WebGL 2.0 context');
        return null;
    }
        
    // make texture from image
    function makeTexture(img)
    {
        const level = 0;
        const internalFormat = gl.RGBA;
        const srcFormat = gl.RGBA;
        const srcType = gl.UNSIGNED_BYTE;      

        const texture = gl.createTexture();
        gl.bindTexture(gl.TEXTURE_2D, texture);
        gl.texImage2D(gl.TEXTURE_2D, level, internalFormat, srcFormat, srcType, img);
        gl.generateMipmap(gl.TEXTURE_2D);
        return texture;
    }

    // make all the textures
    const textures = {};
    for (let k in images)
        textures[k] = makeTexture(images[k]);

    // compile a shader
    function loadShader(type, source) {
        const shader = gl.createShader(type);
        gl.shaderSource(shader, source);
        gl.compileShader(shader);
      
        if (!gl.getShaderParameter(shader, gl.COMPILE_STATUS)) {
          console.error(gl.getShaderInfoLog(shader));
          alert('Could not compile shader (see console for details)');
          gl.deleteShader(shader);
          return null;
        }
      
        return shader;
    }

    // passthrugh vertex shader
    const vsSource = `#version 300 es
        in vec4 aVertexPosition;

        void main() {
            gl_Position = aVertexPosition;
        }
    `;

    // make the shaders and the program
    const vertexShader = loadShader(gl.VERTEX_SHADER, vsSource);
    const fragmentShader = loadShader(gl.FRAGMENT_SHADER, source);
    const shaderProgram = gl.createProgram();
    gl.attachShader(shaderProgram, vertexShader);
    gl.attachShader(shaderProgram, fragmentShader);
    gl.linkProgram(shaderProgram);
  
    if (!gl.getProgramParameter(shaderProgram, gl.LINK_STATUS)) {
        console.error(gl.getProgramInfoLog(shaderProgram));
        alert('Unable to initialize the shader program (see console for details)');
        return null;
    }

    // stuff!
    const programInfo = {
        attribLocations: {
          vertexPosition: gl.getAttribLocation(shaderProgram, 'aVertexPosition'),
        },
        uniformLocations: {
          fGlobalTime: gl.getUniformLocation(shaderProgram, 'fGlobalTime'),
          v2Resolution: gl.getUniformLocation(shaderProgram, 'v2Resolution'),
        },
    };

    // add texture samplers from textures
   
    // make a vertex buffer...
    const positions = [ -1.0,  1.0, 1.0,  1.0, -1.0, -1.0, 1.0, -1.0, ];    
    const posBuffer = gl.createBuffer();
    gl.bindBuffer(gl.ARRAY_BUFFER, posBuffer);
    gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(positions.map(f => f*1)), gl.STATIC_DRAW);
    
    // ... and return the render function!
    return (time, uniforms) => {
        time/=1000; // time is now in seconds
        canvas.width = canvas.parentElement.clientWidth;
        canvas.height = canvas.parentElement.clientHeight;
        
        gl.clearColor(0.5*(Math.sin(time)+1), 0.4, 0.2, 1.0);
        gl.clear(gl.COLOR_BUFFER_BIT);

        // Tell WebGL how to pull out the positions from the position
        // buffer into the vertexPosition attribute.
        {
            const numComponents = 2;  // pull out 2 values per iteration
            const type = gl.FLOAT;    // the data in the buffer is 32bit floats
            const normalize = false;  // don't normalize
            const stride = 0;         // how many bytes to get from one set of values to the next
                                        // 0 = use type and numComponents above
            const offset = 0;         // how many bytes inside the buffer to start from
            gl.bindBuffer(gl.ARRAY_BUFFER, posBuffer);
            gl.vertexAttribPointer(
                programInfo.attribLocations.vertexPosition,
                numComponents,
                type,
                normalize,
                stride,
                offset);
            gl.enableVertexAttribArray(programInfo.attribLocations.vertexPosition);
        }

        // Tell WebGL to use our program when drawing

        gl.useProgram(shaderProgram);

        // Set the shader uniforms
        gl.uniform1f(programInfo.uniformLocations.fGlobalTime, time);
        gl.uniform2f(programInfo.uniformLocations.v2Resolution, canvas.width, canvas.height);
        
        let slot = 0;
        if (textures) {
            for (let k in textures) {
                if (!(k in programInfo.uniformLocations))
                    programInfo.uniformLocations[k] = gl.getUniformLocation(shaderProgram, k);

                if (programInfo.uniformLocations[k])
                {
                    gl.activeTexture(gl.TEXTURE0+slot);
                    gl.bindTexture(gl.TEXTURE_2D, textures[k]);
                    gl.uniform1i(programInfo.uniformLocations[k], slot);
                    slot++;
                }
            }
        }

        if (uniforms) {
            for (let k in uniforms) {
                if (!(k in programInfo.uniformLocations))
                programInfo.uniformLocations[k] = gl.getUniformLocation(shaderProgram, k);

                if (programInfo.uniformLocations[k])
                {            
                    gl.uniform1f(programInfo.uniformLocations[k], uniforms[k]);
                }
            }
        }

        gl.viewport(0,0,canvas.width,canvas.height);

        const offset = 0;
        const vertexCount = 4;
        gl.drawArrays(gl.TRIANGLE_STRIP, offset, vertexCount);        
    }
}