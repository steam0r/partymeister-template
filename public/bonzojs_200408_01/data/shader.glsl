#version 410 core
#pragma optionNV(unroll none)
#pragma optionNV(fastmath on)
#pragma optionNV(fastprecision on)

uniform float fGlobalTime; // in seconds
uniform vec2 v2Resolution; // viewport resolution (in pixels)

uniform float logoFade; // 0.0 to 1.0

uniform sampler2D texIcons;
uniform sampler2D texLogo;

layout(location = 0) out vec4 out_color; // out_color must be written in order to see anything

mat2 rotate(float a) { float s=sin(a), c=cos(a); return mat2(c,s,-s,c); }

float hash(vec2 c){
	return fract(sin(dot(c.xy ,vec2(12.9898,78.233))) * 43758.5453);
}

float T;
const float PI = 4.*atan(1.);

mat3 rotationY( in float angle ) {
	return mat3(cos(angle) , 0.0, sin(angle),
			 			 	0.0        , 1.0,	0.0       ,
					    -sin(angle), 0.0, cos(angle));
}

float particle(vec2 uv, int icon, vec2 pos, float size, float rot)
{
  vec2 tuv = uv;
  
  tuv -= pos;
  tuv.y *= -1.;
  tuv /= size;
  tuv *= rotate(rot);
  tuv += vec2(0.5);
  
  vec4 tex = vec4(0,0,0,0);    
  if (tuv.x>=0. && tuv.x<1. && tuv.y>=0. && tuv.y<1.)
  {
    tuv /= 4.;  
    tuv.x += 0.25 * float(icon % 4);
    tuv.y += 0.25 * float(icon / 4);
    tex = texture(texIcons, tuv);
  }
  return tex.x;
}

float fallingstuff(vec2 uv)
{
  const int NP = 21; 
  float res = 0.;
  
  for (int i=1; i<NP; i++)
  {
    float fi = float(i); 

    float spd = hash(vec2(fi, 6.99));
    float rspd = hash(vec2(fi, 7.99))-0.5;
    float phase = hash(vec2(fi, 123.));

    float x = fi/float(NP-1);
    
    float y = hash(vec2(fi, 3.1));
    y += T*0.2*spd;
    y = 1.-mod(y,1.);

    vec2 pos = vec2((x-0.5)*3.5 + 0.02*sin((T*0.2+phase)*2.*PI), (y-0.5)*2.25);
    float size = 0.25;
    float rot = fGlobalTime * rspd;
    int icon = int(7. * mod(hash(vec2(fi, 4.0)) + T*0.05,1.));
    res += 0.2 * particle(uv,icon,pos,size,rot);
  }  

  return res;
}

vec4 revisionlogo(vec2 uv)
{
  mat3 matrix = mat3(vec3(1,0,0),vec3(0,1,0),vec3(0,0,1));  
  matrix *= rotationY(-0.8);
  
  vec3 ro = vec3(0.13,0.01,-1.1);
  vec3 rd = normalize(vec3(uv,2))*matrix;
  const vec3 n = vec3(0,0,-1);

  vec4 res = vec4(0);
  mat2 rot = rotate(-T*0.5);
  vec3 pos = ro + length(ro) * rd / -dot(rd, n);
  
  for (int i = 0; i<16; i++)
  {
    vec3 lpos = vec3(-1.,0.5,-2);
    
    vec2 tuv = pos.xy;
    tuv.x+=0.5;
    tuv *= rot;
    tuv += 0.5;  
    if (tuv.x < 0. || tuv.x >=1. || tuv.y < 0. || tuv.y >=1.) return vec4(0,0,0,0);
    vec3 tex = texture(texLogo,tuv).xyz;
    
    if (tex.x > 0.)
    {
      vec3 l = lpos-pos;
      float lit = 1.5 * length(lpos) * dot(n,normalize(l)) / dot(l,l);
      
      vec3 col = i>0 ? vec3(0.2,0.5,0.8) : vec3(1,1,1);
      col *= lit;
      col = pow(col, vec3(0.54));

      res = vec4(col*tex.x,tex.x) * (1.-res.w) + res;      
      if (res.w>0.999) break;
    }
    
    pos += 0.01*rd;           
  }
  
  return res;
}

void main(void)
{
  T = fGlobalTime;
  vec2 uv = vec2(gl_FragCoord.x / v2Resolution.x, gl_FragCoord.y / v2Resolution.y);
  uv -= 0.5;
  uv *= 2.;

  float r = sqrt(dot(uv,uv));
  out_color = vec4(0,0,0,1);
  vec2 orguv = uv;    

  const float distort = 0.08; // 0.08

  for (int ch = 0; ch < 3; ch++)
  {
    // distort uv    
    uv = orguv;
    uv *= 1. + r*(distort*(0.05*float(ch)+1.));
    uv *= 0.925;

    // vignette    
    float fade = 1.-(r*0.2);
    fade *= smoothstep(1.005,0.995,abs(uv.x));
    fade *= smoothstep(1.005,0.995,abs(uv.y));
      
    uv /= vec2(v2Resolution.y / v2Resolution.x, 1);
    vec3 col = vec3(76./255., 169./255., 221./255.);   
    col += fallingstuff(uv);    
    vec4 logo = revisionlogo(uv) * logoFade;
    col = col*(1.-logo.w)+logo.xyz;
    col *= fade;
    
    if (ch==2) out_color.x = col.x;
    if (ch==1) out_color.y = col.y;
    if (ch==0) out_color.z = col.z;    
  }

  out_color.xyz*=vec3(1,0.95,0.9);  
  out_color.xyz += 1.0/255.0 * hash(orguv+vec2(T));
}