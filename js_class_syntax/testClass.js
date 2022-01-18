import TestConsole2 from "./testClass2.js";
import $ from 'https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js';

class TestConsole extends TestConsole2{
	constructor() {
		super();
		console.log("imported");
	}

	test2(){
		const test2 = 'test2';
		return $(test2).len();
	}

}

export default TestConsole;

