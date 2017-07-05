<?php

?>
<style>
    #proclaim-status-panel {
        position: fixed;
        border-bottom: 4px solid #afafaf;
        z-index: 1000;
        bottom: 1rem;
        right: 1rem;
        width: 300px;
        height: 50px;
        padding: 1rem;
        background-color: #efefef;
        font-size: 0.8rem;
        cursor: move;
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
    // From Shaedo on SO
    // https://stackoverflow.com/questions/13152578/create-a-draggable-div-in-native-javascript
    function get (el) {
        if (typeof el == 'string') return document.getElementById(el);
        return el;
    }

    var dragObj = null; //object to be moved
    var xOffset = 0; //used to prevent dragged object jumping to mouse location
    var yOffset = 0;
    var el;
        
    window.onload = function()
    {
        el = document.getElementById("proclaim-status-panel");
        el.addEventListener("mousedown", startDrag, true);
        el.addEventListener("touchstart", startDrag, true);
    }

    function startDrag(e)
    /*sets offset parameters and starts listening for mouse-move*/
    {   
        // Prevent children from becoming draggable
        if( e.target === el ) {

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

        } //endif

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