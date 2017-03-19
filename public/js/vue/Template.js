/**
 * Created by AlbertLin on 2017/3/17.
 */

function Template(config){

	/**
	 * template name
	 * @type {undefined}
	 */
	this.template = undefined;

	/**
	 * the config object of current Template
	 * @type {{}}
	 */
	this.config = {};

	/**
	 * block(s) initialization for all templates
	 * @param config
	 * @constructor
	 */
	this.Template = function(config){
		this.template = config.template;
		this[this.template] = {};
		switch(config.template){
			case 'blank':
				this.blank.block0 = grid();
				break;
			case 'temp0':
				this.temp0.block0 = grid();
				this.temp0.block1 = grid();
				this.temp0.block2 = grid();
				break;
		}
	};

	/**
	 * the default config object for GridSystem
	 * @returns {{grid: string, prop: {componentData: Array, classArray: {lg: [number,number], md: [number,number], sm: [number,number], xs: [number,number]}}}}
	 */
	let grid = function(){
		return {
			grid: 'gridSystem',
			prop: {
				componentData: [],
				classArray: {
					lg: [0, 12],
					md: [0, 12],
					sm: [0, 12],
					xs: [0, 12]
				}
			}
		};
	};

	/**
	 * get the information of specific block in current Template
	 * @param blockName
	 * @returns {*}
	 */
	this.getSingleBlock = function(blockName){
		return this[this.template][blockName];
	};

	/**
	 * set specific block of current Template
	 * @param blockName
	 * @param config
	 */
	this.setSingleBlock = function(blockName, config){
		this[this.template][blockName] = config;
	};

	/**
	 * set all blocks and generate the config of current Template
	 * @param config
	 */
	this.setBlock = function(config){
		for(let block in config){
			if(block !== 'template'){
				for(let col in config[block]){
					if(col === 'componentData'){
						this[this.template][block].prop.componentData = config[block].componentData;
						this[this.template][block].prop.block = block;
					}
					else{
						let colData = config[block][col];
						if(Array.isArray(colData) !== true){
							colData = [0, colData];
						}
						this[this.template][block].prop.classArray[col] = colData;
					}
				}
			}
		}

		this.config = { template: this.template, prop: {} };
		for(let block in this[this.template]){
			this.config.prop[block] = this[this.template][block];
		}
	};

	// execute:
	this.Template(config);
	this.setBlock(config);
}