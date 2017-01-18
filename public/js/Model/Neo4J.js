/* 
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/

function Neo4J(){

	var server = "bolt://localhost";
	var driver;
	var session;
	var authToken;
	this.query;


	/**
	 * Setting server URI which going to be connected
	 * @param {type} URI
	 * @returns {undefined}
	 */
	this.setServerURI = function(URI){
		// validation process missing
		server = URI;
	};


	/**
	 * Connecting to the Neo4J server
	 * @param {String} account
	 * @param {String} password
	 * @returns {undefined}
	 */
	this.connection = function(account, password){
		authToken = neo4j.v1.auth.basic(account, password);
		driver = neo4j.v1.driver(server, authToken, {
				encrypted:false
		});
		session = driver.session();
	};


	/**
	 *
	 * @param {String} cypher
	 * @param {Object} processObject The formate must be:
	 * {
	 *		"nextFun": { Function(records) },
	 *		"completedFun": { Function(parameters) },
	 *		"parameters": {Object|Array}
	 *	}
	 * @returns {undefined}
	 */
	this.queryProcess = function(cypher, processObject){
		this.query = cypher;
		session
		.run(this.query)
		.subscribe({
			onNext: function(record){
				if(isFunction(processObject.nextFun)){
					processObject.nextFun(record);
				}
			},
			onCompleted: function(metadata){
				session.close();
				driver.close();
				if(isFunction(processObject.completedFun)){
					processObject.completedFun();
				}
			}
		});

	};

}
