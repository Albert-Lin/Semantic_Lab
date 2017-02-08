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
    #sparqlResult{
        display: none;
    }
        #sparqlResult>.boxHeader{
            background-color: #f0ad4e;
        }
</style>
<div class="row">
    <div id="sparqlSearch" class="col-md-offset-1 col-md-10 layoutBox">
        <div class="boxHeader">
            <div class="form-group">
                <select class="form-control">
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
        <div class="boxFooter"><button id="searchDBpedia" class="btn btn-info"> SEARCH </button></div>
    </div>
</div>
<div class="row">
    <div id="sparqlResult" class="col-md-offset-1 col-md-10 boxLayout">
        <div class="boxHeader">Search Result:</div>
        <div id="sparqlResultBody" class="boxBody" ></div>
    </div>
</div>
