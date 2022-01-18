const op        = require("./shop_codes.js"); 
const request   = require("request");
const cheerio   = require("cheerio");
const puppeteer = require("puppeteer");

async function updateRates() {

	try {

		await handleBrowser();
		await getAisekiyaRates();
		await getEveRates();
		await getJisRates();
		await browser.close();

	} catch (error) {
		console.log(error);
	}

}

updateRates();

async function getAisekiyaRates() {

	try {

		await Promise.all([
			page.waitForNavigation({ waitUntil: ['load', 'networkidle2'], timeout: 0 }),
			page.goto('https://aiseki-ya.com/'),
		]);

		const html = await page.$eval('body', item => {
			return item.innerHTML;
		});

		const $ = await cheerio.load(html);
		let datas = [];

		await page.waitForSelector('.con_shop');

		$('.con_shop').each((i, e) => {

			if(!$(e).hasClass('close')){

				const code   = 'aisekiya_' + $(e).find('.shopname').text().toLocaleLowerCase();
				const mens   = $(e).find('.cong_man > span').text();
				const womens = $(e).find('.cong_woman > span').text();
				const id     = op.shops[code];
				let item = {
					'id':id,
					'mens':mens,
					'womens':womens,
				};
	
				datas.push(item);
	
			}

		});

		$(datas).each((i,e) => {
			postRequest(e);
		});

	} catch (error) {

	}

}

async function getEveRates() {

	try {

		await Promise.all([
			page.waitForNavigation({ waitUntil: ['load', 'networkidle2'], timeout: 0 }),
			page.goto('https://oriental-lounge.com/'),
		]);

		const html = await page.$eval('body', item => {
			return item.innerHTML;
		});

		const $   = await cheerio.load(html);
		let datas = [];

		$('.shop_block').each((i, e) => {

			const code   = 'eve_' + $(e).find('span.en').text().toLocaleLowerCase();
			const mens   = $(e).find('li.man').text();
			const womens = $(e).find('li.woman').text();
			const id     = op.shops[code];
			let item = {
				'id':id,
				'mens':mens,
				'womens':womens,
			};

			datas.push(item);

		});

		$(datas).each((i,e) => {
			postRequest(e);
		});

	} catch (error) {

	}

}

async function getJisRates() {

	try {

		await Promise.all([
			page.waitForNavigation({ waitUntil: ['load', 'networkidle2'], timeout: 0 }),
			page.goto('https://jis.bar/'),
		]);

		const html = await page.$eval('#storelink', item => {
			return item.innerHTML;
		});

		const $ = await cheerio.load(html);
		let datas = [];

		$('.col-md-4.col-sm-6.mgb-30').each((i, e) => {

			const code   = 'jis_' + $(e).find('.storename').text().toLocaleLowerCase();
			const mens   = $(e).find('.mens').text();
			const womens = $(e).find('.ladys').text();
			const id     = op.shops[code];
			let item = {
				'id':id,
				'mens':mens,
				'womens':womens,
			};

			datas.push(item);

		});

		$(datas).each((i,e) => {
			postRequest(e);
		});

	} catch (error) {

	}

}

async function handleBrowser() {

	browser = await puppeteer.launch({
		args: ['--no-sandbox', '--disable-setuid-sandbox'],
		defaultViewport: { width: 1280, height: 8000 },
		headless: true,
	});

	page = await browser.newPage();

}

function postRequest(data) {

	var options = {
		url:'https://sittingtogether.herokuapp.com/api/rates/' + data.id,
		headers: {
			"Content-type": "application/x-www-form-urlencoded",
		},
		form: {
			"mens":data.mens,
			"womens":data.womens,
			"_method":"PUT",
		}
	}

	console.log(options);
	request.post(options, function (error, response, body) { });

}