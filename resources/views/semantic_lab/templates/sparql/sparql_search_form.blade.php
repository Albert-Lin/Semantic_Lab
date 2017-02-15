<?php
/**
 * Created by PhpStorm.
 * User: Albert Lin
 * Date: 2017/2/7
 * Time: 上午 01:19
 */
?>

<style>
    #sparqlEditor{
        width: 100%;
        border:0;
        padding: 15px;
        resize: none;
    }
        #sparqlSearch>.boxHeader{
            background-color: #5b88de;
        }
        #sparqlSearch>.boxHeader>.form-group, #sparqlSearch>.boxHeader>.form-group>.form-control{
            padding-right: 15px;
            font-size: 16px;
            font-weight: bolder;
            float: left;
        }
        #sparqlSearch>.boxHeader>.form-group>.form-control>option{
            line-height: 18px;
            font-size: 16px;
            font-weight: bolder;
        }

        #sparqlSearch>div>.footerBtn{
            float: left;
            padding-left: 15px;
            padding-right: 15px;
        }

        #sparqlSearch>div>.inputError{
            text-align: center;
            display: none;
            float: right;
            padding-bottom: 0;
        }

</style>
<div class="row sparqlBlock">
    <div id="sparqlSearch" class="col-md-offset-1 col-md-10 layoutBox">
        <div class="boxHeader">
            <div class="form-group">
                <select id="sparqlResource" class="form-control">
                    <option>DBpedia</option>
                    <option>WordNet</option>
                    <option>Semantic Lab</option>
                </select>
            </div>
            SPARQL Editor:
        </div>
        <textarea id="sparqlEditor" class="boxBody" rows="7">
SELECT DISTINCT
WHERE
{
}
        </textarea>
        <div class="boxFooter row">
            <div class="footerBtn"><button id="sparqlBtn" class="btn btn-info"> SEARCH </button></div>
            <div class="inputError"> LOADING ... </div>
        </div>
    </div>
</div>

<script>
    $(function(){

        $( document ).ajaxStart(function() {
            $('#sparqlSearch .inputError').css('display', 'block');
        });

        $( document ).ajaxStop(function() {
            $('#sparqlSearch .inputError').css('display', 'none');
        });

        $('#sparqlBtn').on('click', function(){
            var passData = {
                domainURI: $('#domainURI').val(),
                resource: $('#sparqlResource').find(':selected').html(),
                query: $('#sparqlEditor').val(),
                successFun: function (xhrResponseText) {
                    var message = $.parseJSON(xhrResponseText);
                    if(message.title === 'Success'){
                    	var queryKeys = message.key;
                    	var queryResults = message.content;
                        var table = '<div class="table-responsive sparqlTBBlock"><table id="sparqlResultTB" class="table table-striped">'+
                            '<thead><tr>';
                        for(var i = 0; i < queryKeys.length; i++){
                        	table += '<td>'+queryKeys[i]+'</td>';
                        }
                        table += '</tr></thead><tbody>';
                        for(var i = 0; i < queryResults.length; i++){
                        	table += '<tr>';
                        	$.each(queryResults[i], function(key, value){
                        		if(!key.includes('type') && !key.includes('lang')){
                        			table += '<td>'+value+'</td>';
                                }
                            });
                            table += '</tr>';
                        }
                        table += '</tbody></table></div>';

                        $('#sparqlResultBody').html(table);
                        $('#sparqlResultBlock').css('display', 'block');
                    }
                    else if(message.title === 'Error'){
						messageBox(message);
                    }
                }
            };
            var ajaxObject = new AjaxObject('sparql', 'select', passData);
            ajaxObject.ajaxCSRFHeader();
            $.ajax(ajaxObject.ajax);
        });
    });
</script>