<?php
/**
 * Created by PhpStorm.
 * User: Albert Lin
 * Date: 2017/2/7
 * Time: 上午 01:19
 */
?>

<style>
    #sparqlSearch{
        padding: 0;
        margin-top: 5%;
        background-color: #FFFFFF;
        box-shadow: 0 4px 10px 0 rgba(60, 32, 64, 0.5), 0 6px 40px 0 rgba(60, 32, 64, 0.49);
        font-weight: bolder;
    }
    #sparqlEditor{
        width: 100%;
        border:0;
        padding: 15px;
        resize: none;
    }
        #sparqlSearch>.itemFormTitle{
            padding-top: 20px;
            padding-right: 15px;
            padding-bottom: 20px;
            padding-left: 15px;
            background-color: #5b88de;
        }
    #sparqlSearch>.searchBtn{
        padding: 8px;
    }
    #sparqlResult{
        padding: 0;
        margin-top: 5%;
        background-color: #FFFFFF;
        box-shadow: 0 4px 10px 0 rgba(60, 32, 64, 0.5), 0 6px 40px 0 rgba(60, 32, 64, 0.49);
        font-weight: bolder;
        display: none;
    }
        #sparqlResult>.itemFormTitle{
            padding-top: 20px;
            padding-right: 15px;
            padding-bottom: 20px;
            padding-left: 15px;
            background-color: #f0ad4e;
        }
</style>
<div class="row">
    <div id="sparqlSearch" class="col-md-offset-1 col-md-10 h100">
        <div class="itemFormTitle">SPARQL Editor:</div>
        <textarea id="sparqlEditor" rows="7">
SELECT DISTINCT
WHERE
{
}
        </textarea>
        <div class="searchBtn"><button id="searchDBpedia" class="btn btn-info"> SEARCH </button></div>
    </div>
</div>
<div class="row">
    <div id="sparqlResult" class="col-md-offset-1 col-md-10 h100">
        <div class="itemFormTitle">Search Result:</div>
        <div id="sparqlResultBody"></div>
    </div>
</div>
