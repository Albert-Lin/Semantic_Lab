/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Function for checking parameter is a function or not.
 * @param {Function} fun
 * @returns {Boolean}
 */
function isFunction(fun){
	var object = {};
	var type = object.toString.call(fun);
	if(type === "[object Function]"){
			return true;
	}
	else{
			return false;
	}
}

/**
 *
 * @param container
 * @param domIdName
 * @param svgId
 * @param imgPath
 */
function svgAppendPattern(container, domIdName, svgId, imgPath){
	container.append("pattern")
		.attr("id", domIdName+"_"+svgId)
		.attr("width", "5")
		.attr("height", "5")
		.append("image")
		.attr("href", imgPath)
		.attr("x", "0")
		.attr("y", "0")
		.attr("width", "52")
		.attr("height", "52");
}

/**
 * 
 * @param object
 * @param info
 * @returns {undefined}
 */
function keyValuesTable(object, info){
	var table = '<table class="table">'+
					'<thead><tr>  <td class="col-md-4">Property</td> <td class="col-md-8">Value</td>  </tr></thead>'+
					'<tbody>';

	for(var key in info){
		table += '<tr> <td class="col-md-4">'+key+'</td> <td class="col-md-8">'+info[key]+'</td> </tr>';
	}

	for(var key in object){
		table += '<tr> <td class="col-md-4">'+key+'</td> <td class="col-md-8">'+object[key]+'</td> </tr>';
	}

	table += '</tbody></table>';
	return table;
}

/**
 *
 * @param array
 * @param propName
 * @param invers
 * @returns {*}
 */
function sortData(array, propName, invers){
	var newArray;
	if(typeof invers === 'undefined'){
		// small -> large
		newArray = array.slice().sort(function(a, b){
			return a[propName] - b[propName];
			if(a[propName] < b[propName]){
				return -1;
			}
			if(a[propName] > b[propName]){
				return 1;
			}
			return 0;
		});
	}
	else{
		// large -> small
		newArray = array.slice().sort(function(a, b){
			if(b[propName] < a[propName]){
				return -1;
			}
			if(b[propName] > a[propName]){
				return 1;
			}
			return 0;
		});
	}

	return newArray;
}
