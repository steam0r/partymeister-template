const puppeteer = require('puppeteer');
let slideId = null;
process.argv.forEach(function (val, index, array) {
    if (index == 2) {
		let slides = JSON.parse(val).slides;

	    (async () => {

		    puppeteer.launch().then(async browser => {
		         const promises=[];
		         for(let slide of slides){
		           console.log('Page ID Spawned', slide)

  					 await (async () => {
  					   await delay(2000);
  					 })();

		           promises.push(browser.newPage().then(async page => {

			           await page._client.send(
			               'Emulation.setDefaultBackgroundColorOverride',
			               { color: { r: 0, g: 0, b: 0, a: 0 } }
			           );

					 await page.setViewport({width: 1920, height: 1080});
					 await page.goto('http://pm3.test/backend/slides/'+slide, {"waitUntil" : "networkidle0"});
					 

		             await page.screenshot({path: 'storage/app/result' + slide + '.png'});

		           }))


	           console.log('Page ID Spawned', slide)

					 await (async () => {
					   await delay(2000);
					 })();

	           promises.push(browser.newPage().then(async page => {

		           await page._client.send(
		               'Emulation.setDefaultBackgroundColorOverride',
		               { color: { r: 0, g: 0, b: 0, a: 0 } }
		           );

				 await page.setViewport({width: 1920, height: 1080});
				 await page.goto('http://pm3.test/backend/slides/'+slide+'?preview=true', {"waitUntil" : "networkidle0"});
				 

	             await page.screenshot({path: 'storage/app/result' + slide + 'preview.png'});

	           }))
		         }
		         await Promise.all(promises)
		         browser.close();
		       });
	    })();



    }
});


function delay(timeout) {
  return new Promise((resolve) => {
    setTimeout(resolve, timeout);
  });
}

//if (slideId > 0) {
//    (async () => {
//        const browser = await puppeteer.launch();
//        const page = await browser.newPage();
//
//        await page.setViewport({width: 1920, height: 1080});
//        await page.goto('http://pm3.test/backend/slides/'+slideId);

//        let filename = Math.floor((Math.random() * 100000000) + 1)+'.png';
//        await page.screenshot({path: 'storage/app/temp/'+filename});
//        console.log('storage/app/temp/'+filename);

//        await browser.close();
//    })();
//}
