<?php

?>
<style>
    #proclaim-status-panel {
        position: fixed;
        z-index: 1000;
        bottom: 15px;
        right: 15px;
        width: 300px;
        height: 50px;
        padding: 15px;
        background-color: #efefef;
        font-size: .8rem;
    }
</style>
<div id="proclaim-status-panel"> 
    <?php 
        $Proclaim->_memory_end = memory_get_usage();
        $Proclaim->update_memory_usage();
        $Proclaim->update_exec_time();
        echo $Proclaim->report_efficiency();
    ?> 
</div>
<script type="text/javascript">
    function get (el) {
        if (typeof el == 'string') return document.getElementById(el);
        return el;
    }

    var dragObj = null; //object to be moved
    var xOffset = 0; //used to prevent dragged object jumping to mouse location
    var yOffset = 0;
        
    window.onload = function()
    {
        document.getElementById("proclaim-status-panel").addEventListener("mousedown", startDrag, true);
        document.getElementById("proclaim-status-panel").addEventListener("touchstart", startDrag, true);
    }

    function startDrag(e)
    /*sets offset parameters and starts listening for mouse-move*/
    {
        e.preventDefault();
        e.stopPropagation();
        dragObj = e.target;
        dragObj.style.position = "absolute";
        var rect = dragObj.getBoundingClientRect();
        
        if(e.type=="mousedown")
        {
            xOffset = e.clientX - rect.left; //clientX and getBoundingClientRect() both use viewable area adjusted when scrolling aka 'viewport'
            yOffset = e.clientY - rect.top;
            window.addEventListener('mousemove', dragObject, true);
        }
        else if(e.type=="touchstart")
        {
            xOffset = e.targetTouches[0].clientX - rect.left; //clientX and getBoundingClientRect() both use viewable area adjusted when scrolling aka 'viewport'
            yOffset = e.targetTouches[0].clientY - rect.top;
            window.addEventListener('touchmove', dragObject, true);
        }
    }

    function dragObject(e)
    /*Drag object*/
    {
        e.preventDefault();
        e.stopPropagation();
        
        if(dragObj == null) return; // if there is no object being dragged then do nothing
        else if(e.type=="mousemove")
        {
            dragObj.style.left = e.clientX-xOffset +"px"; // adjust location of dragged object so doesn't jump to mouse position
            dragObj.style.top = e.clientY-yOffset +"px";
        }
        else if(e.type=="touchmove")
        {
            dragObj.style.left = e.targetTouches[0].clientX-xOffset +"px"; // adjust location of dragged object so doesn't jump to mouse position
            dragObj.style.top = e.targetTouches[0].clientY-yOffset +"px";
        }
    }

    document.onmouseup = function(e)
    /*End dragging*/
    {
        if(dragObj) 
        {
            dragObj = null;
            window.removeEventListener('mousemove', dragObject, true);
            window.removeEventListener('touchmove', dragObject, true);
        }
    }
</script>