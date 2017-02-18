/**
 * Created by AlbertLin on 2017/2/17.
 */

/**
 * An Entity Class for most JSON Data to use
 * @param data : a JSON object {}
 * @constructor
 */
function Entity(data) {
	/**
	 * all properties name of original JSON object
	 * @type {Array}
	 */
	this.propNames = [];

	/**
	 * A hash map of properties name
	 * @type {Array}
	 */
	this.propNameMap = [];

	/**
	 * all properties value of original JSON object,
	 *  also, the order of each values is matched to this.propNames
	 * @type {Array}
	 */
	this.propValues = [];

	/**
	 * special property(type of array)
	 *  which sorted by special property of element
	 * @type {Array}
	 */
	this.sortedElementList = [];

	/**
	 * a list of array,
	 *  each element(array) grouped by special condiction
	 * @type {Array}
	 */
	this.groupList = [];

	/**
	 * a search result of special property(type of array)
	 * @type {Array}
	 */
	this.searchResultList = [];

	this.init = function(data){
		this.propNames = Object.keys(data);
		for(var i = 0; i < this.propNames.length; i++){
			this.propNameMap[this.propNames[i]] = i;

			if( Array.isArray(data[this.propNames[i]]) === true ){
				data[this.propNames[i]] = this.setArrayElementIndex(data[this.propNames[i]]);
			}
			this.propValues.push(data[this.propNames[i]]);
		}
	};

	this.getPropValue = function(propName){
		var propIndex = this.propNameMap[propName];
		return this.propValues[propIndex];
	};

	this.setPropValue = function(propName, value){
		var propIndex = this.propNameMap[propName];
		this.propValues[propIndex] = value;
	};

	this.getElementValue = function(propName, index){
		var result = this.getPropValue(propName);
		if(Array.isArray(result)){
			return result[index];
		}
		else{
			return result;
		}
	};

	this.setElementValue = function(propName, index, value){
		var result = this.getPropValue(propName);
		if(Array.isArray(result)){
			result[index] = value;
			this.setPropValue(propName, result);
		}
		else{
			this.setPropValue(propName, value);
		}
	};

	this.setArrayElementIndex = function(array){
		for(var i = 0; i < array.length; i++){
			array[i].origIndex = i;
		}
		return array;
	};

	this.sortArrayElement = function(propName, sortColumn){
		if(typeof propName !== 'undefined' && typeof sortColumn !== 'undefined'){
			this.sortedElementList = sortDataIndex(this.get(propName), sortColumn, 'origIndex');
		}
		else{
			console.log('Please set parameters');
		}
	};

	this.groupElements = function(conditions, fun){
		var num = conditions.length;
		var none_empty = false;
		for(var i = 0; i < num; i++){
			var condition = conditions[i];
			var result = fun(condition, this);
			this.groupList.push(result);
			if(result.length > 0 ){
				none_empty = true;
			}
		}

		return none_empty;
	};

	this.specialFun = function(funParam, fun){
		fun(funParam, this);
	};

	this.init(data);
}
