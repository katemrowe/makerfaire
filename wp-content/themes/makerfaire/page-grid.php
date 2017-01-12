<?php
/**
 * Template Name: GridTest
 */
get_header(); ?>

<div class="clear"></div>

<div class="container clear">
   


    <script type="text/javascript"> 
    jQuery(document).ready(function () {
        

    jQuery("#grid-basic").bootgrid();

    });
 
   </script>


<table class="table table-condensed table-hover table-striped bootgrid-table" id="grid-basic" aria-busy="false">
                    <thead>
                        <tr><th class="text-left" data-column-id="id"><a class="column-header-anchor sortable" href="javascript:void(0);"><span class="text">ID</span><span class="icon glyphicon "></span></a></th><th class="text-left" data-column-id="sender"><a class="column-header-anchor sortable" href="javascript:void(0);"><span class="text">Sender</span><span class="icon glyphicon "></span></a></th><th class="text-left" data-column-id="received"><a class="column-header-anchor sortable" href="javascript:void(0);"><span class="text">Received</span><span class="icon glyphicon glyphicon-chevron-down"></span></a></th></tr>
                    </thead>
                    <tbody><tr data-row-id="0"><td class="text-left">10253</td><td class="text-left">eduardo@pingpong.com</td><td class="text-left">29.10.2013</td></tr><tr data-row-id="1"><td class="text-left">10252</td><td class="text-left">robert@bingo.com</td><td class="text-left">28.10.2013</td></tr><tr data-row-id="2"><td class="text-left">10251</td><td class="text-left">simon@yahoo.com</td><td class="text-left">27.10.2013</td></tr><tr data-row-id="3"><td class="text-left">10250</td><td class="text-left">tim@microsoft.com</td><td class="text-left">26.10.2013</td></tr><tr data-row-id="4"><td class="text-left">10249</td><td class="text-left">lila@google.com</td><td class="text-left">25.10.2013</td></tr><tr data-row-id="5"><td class="text-left">10248</td><td class="text-left">eduardo@pingpong.com</td><td class="text-left">24.10.2013</td></tr><tr data-row-id="6"><td class="text-left">10247</td><td class="text-left">robert@bingo.com</td><td class="text-left">23.10.2013</td></tr><tr data-row-id="7"><td class="text-left">10246</td><td class="text-left">simon@yahoo.com</td><td class="text-left">22.10.2013</td></tr><tr data-row-id="8"><td class="text-left">10245</td><td class="text-left">tim@microsoft.com</td><td class="text-left">21.10.2013</td></tr><tr data-row-id="9"><td class="text-left">10244</td><td class="text-left">lila@google.com</td><td class="text-left">20.10.2013</td></tr></tbody>
                </table>

    
</div><!--Container-->

<?php get_footer(); ?>