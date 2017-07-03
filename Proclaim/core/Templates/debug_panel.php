<?php

?>
<style>
    .proclaim-status-panel {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        height: auto;
        min-height: 50px;
        padding: 15px;
        background-color: #efefef;
        font-size: .8rem;
    }
    body {
        padding-bottom: 50px;
    }
</style>
<div class="proclaim-status-panel"> 
    <?php 
        $Proclaim->_memory_end = memory_get_usage();
        $Proclaim->update_memory_usage();
        $Proclaim->update_exec_time();
        echo $Proclaim->report_efficiency();
    ?> 
</div>