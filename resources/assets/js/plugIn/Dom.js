/**
 * Created by AlbertLin on 2017/3/16.
 */

(function(){
	// Ψ: `U03A8

	window.Ψ = function(selector, context){
		let result = [];
		let selectorString = selector.replace(/ /g, '');
		let selectorArray = selectorString.split('>');
		let domSelect = function(selector, context){
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
			if(Array.isArray(subContext) === true || subContext.length > 0){
				for(let i = 0; i < subContext.length; i++){
					let subResult = Ψ(subSelector, subContext[i]);
					for(let j = 0; j < subResult.length; j++){
						result.push(subResult[j]);
					}
				}
			}
			else{
				let subResult = Ψ(subSelector, subContext[i]);
				for(let j = 0; j < subResult.length; j++){
					result.push(subResult[j]);
				}
			}
		}
		else{
			if(Array.isArray(context) === true || context.length > 0){
				for(let i = 0; i < context.length; i++){
					let subResult = Ψ(selector, context[i]);
					for(let j = 0; j < subResult.length; j++){
						result.push(subResult[j]);
					}
				}
			}
			else{
				result = domSelect(selector, context);
			}
		}

		return result;
	};

})();