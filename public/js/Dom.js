/**
 * Created by AlbertLin on 2017/3/16.
 */

(function(){
	// Ψ: `U03A8
	// window.Ψ = function(selector, context){
	// 	let result = undefined;
	// 	let selectorArray = selector.replace(/ /g, '').split('>');
	// 	let singleDom = function(selector, context){
	// 		let result = undefined;
	// 		if(selector.indexOf('#') === 0){
	// 			let id = context.getElementById(selector.replace(/#/g, ''));
	// 			if(id === null || id === undefined){
	// 				console.warn('Ψ Error: There is no id named: '+selector.replace(/#/g, ''));
	// 			}
	// 			else{
	// 				result = id;
	// 			}
	// 		}
	// 		else if(selector.indexOf('.') === 0){
	// 			let classes = context.getElementsByClassName(selector.replace(/\./g, ''));
	// 			if(classes === null || classes === undefined){
	// 				console.warn('Ψ Error: There is no class named: '+selector.replace(/\./g, ''));
	// 			}
	// 			else{
	// 				result = classes;
	// 			}
	// 		}
	// 		else{
	// 			let tags = context.getElementsByTagName(selector);
	// 			if(tags === null || tags === undefined){
	// 				console.warn('Ψ Error: There is no tag named: '+selector);
	// 			}
	// 			else{
	// 				result = tags;
	// 			}
	// 		}
	//
	// 		return result;
	// 	};
	//
	// 	selector = selector.replace(/ /g, '');
	// 	if(typeof context === 'undefined'){
	// 		context = document;
	// 	}
	// 	if(selectorArray.length > 1){
	// 		context = singleDom(selectorArray[0], context);
	// 		if(context !== null || context !== undefined){
	// 			console.log(selector);
	// 			console.log(selectorArray[0]);
	// 			console.log(selector.replace(selectorArray[0]+'>', ''));
	// 			console.log("==============================");
	// 			result = Ψ(selector.replace(selectorArray[0]+'>', ''), context);
	// 		}
	// 	}
	// 	else{
	// 		result = singleDom(selector, context);
	// 	}
	//
	// 	return result;
	// }

	window.Ψ = function(selector, context){
		let result = [];
		let selectorString = selector.replace(/ /g, '');
		let selectorArray = selectorString.split('>');
		let domSelect = function(selector, context){ console.log(context);
			let result = [];

			if(selector.indexOf('#') === 0){
				let idEl = context.getElementById(selector.replace(/#/g, ''));
				if(idEl !== null && idEl !== undefined){
					result = idEl;
				}
			}
			else if(selector.indexOf('.') === 0){
				let classEl = context.getElementsByClassName(selector.replace(/\./g, ''));
				if(classEl !== null && classEl !== undefined){
					result = classEl;
				}
			}
			else{
				let tagEl = context.getElementsByTagName(selector);
				if(tagEl !== null && tagEl !== undefined){
					result = tagEl;
				}
			}

			return result;
		};

		if(typeof context === 'undefined'){
			context = document;
		}

		if(selectorArray.length > 1){
			let subContext = domSelect(selectorArray[0], context);
			let subSelector = selectorString.replace(selectorArray[0]+'>', '');
			if(Array.isArray(subContext) === true){
				for(let i = 0; i < subContext.length; i++){
					let subResult = Ψ(subSelector, subContext[i]);
					result = result.concat(subResult);
				}
			}
			else{
				let subResult = Ψ(subSelector, subContext);
				result = result.concat(subResult);
			}
		}
		else{
			result = domSelect(selector, context);
		}

		if(Array.isArray(result) === true && result.length === 1){
			result = [].slice.call(result[0]);
		}

		return result;
	};

})();