<div class="pagination">
    
    <!-- Page <b><? echo $pagination['current']; ?></b> of <b><? echo $pagination['count']; ?></b> -->
	
    <? if( $pagination['prev'] ){ ?>
        <div class="prev">
            <a href="<? echo $pagination['prev']; ?>">
                <span class="fa fa-caret-left"></span> Prev
            </a>
        </div>
    <? } ?>
	
    <? if( $pagination['next'] ){ ?>
        <div class="next">
            <a href="<? echo $pagination['next']; ?>">
                Next <span class="fa fa-caret-right"></span>
            </a>
        </div>
    <? } ?>
    
</div>