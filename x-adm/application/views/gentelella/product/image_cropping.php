<!-- image cropping -->
<div class="container cropper">
    <div class="row">
        <div class="col-md-12">
            <div class="img-container">
                <img id="image" src="images/cropper.jpg" alt="Picture">
            </div>
        </div>
        <div class="col-md-3">
            <div class="docs-preview clearfix">
                <div class="img-preview preview-lg"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-9 docs-buttons">
            <!-- <h3 class="page-header">Toolbar:</h3> -->
            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="move" title="Move">
                <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;setDragMode&quot;, &quot;move&quot;)">
                <span class="fa fa-arrows"></span>
                </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="crop" title="Crop">
                <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;setDragMode&quot;, &quot;crop&quot;)">
                <span class="fa fa-crop"></span>
                </span>
                </button>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="zoom" data-option="0.1" title="Zoom In">
                <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;zoom&quot;, 0.1)">
                <span class="fa fa-search-plus"></span>
                </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="zoom" data-option="-0.1" title="Zoom Out">
                <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;zoom&quot;, -0.1)">
                <span class="fa fa-search-minus"></span>
                </span>
                </button>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
                <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;move&quot;, -10, 0)">
                <span class="fa fa-arrow-left"></span>
                </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="move" data-option="10" data-second-option="0" title="Move Right">
                <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;move&quot;, 10, 0)">
                <span class="fa fa-arrow-right"></span>
                </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
                <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;move&quot;, 0, -10)">
                <span class="fa fa-arrow-up"></span>
                </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="10" title="Move Down">
                <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;move&quot;, 0, 10)">
                <span class="fa fa-arrow-down"></span>
                </span>
                </button>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45" title="Rotate Left">
                <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;rotate&quot;, -45)">
                <span class="fa fa-rotate-left"></span>
                </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="rotate" data-option="45" title="Rotate Right">
                <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;rotate&quot;, 45)">
                <span class="fa fa-rotate-right"></span>
                </span>
                </button>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="scaleX" data-option="-1" title="Flip Horizontal">
                <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;scaleX&quot;, -1)">
                <span class="fa fa-arrows-h"></span>
                </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="scaleY" data-option="-1" title="Flip Vertical">
                <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;scaleY&quot;, -1)">
                <span class="fa fa-arrows-v"></span>
                </span>
                </button>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="crop" title="Crop">
                <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;crop&quot;)">
                <span class="fa fa-check"></span>
                </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="clear" title="Clear">
                <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;clear&quot;)">
                <span class="fa fa-remove"></span>
                </span>
                </button>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="disable" title="Disable">
                <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;disable&quot;)">
                <span class="fa fa-lock"></span>
                </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="enable" title="Enable">
                <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;enable&quot;)">
                <span class="fa fa-unlock"></span>
                </span>
                </button>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="reset" title="Reset">
                <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;reset&quot;)">
                <span class="fa fa-refresh"></span>
                </span>
                </button>
                <label class="btn btn-primary btn-upload" for="inputImage" title="Upload image file">
                <input type="file" class="sr-only" id="inputImage" name="file" accept="image/*">
                <span class="docs-tooltip" data-toggle="tooltip" title="Import image with Blob URLs">
                <span class="fa fa-upload"></span>
                </span>
                </label>
                <button type="button" class="btn btn-primary" data-method="destroy" title="Destroy">
                <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;destroy&quot;)">
                <span class="fa fa-power-off"></span>
                </span>
                </button>
            </div>
            
            <!-- Show the cropped image in modal -->
            <div class="modal fade docs-cropped" id="getCroppedCanvasModal" aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" role="dialog" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="getCroppedCanvasTitle">Cropped</h4>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <a class="btn btn-primary" id="download" href="javascript:void(0);" download="cropped.png">Download</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal -->
        </div>
        <!-- /.docs-buttons -->
        <div class="col-md-3 docs-toggles">
            <!-- <h3 class="page-header">Toggles:</h3> -->
            
            
            <div class="dropup docs-options">
                
                <ul class="dropdown-menu" aria-labelledby="toggleOptions" role="menu">
                    <li role="presentation">
                        <label class="checkbox-inline">
                        <input type="checkbox" name="responsive" checked>
                        responsive
                        </label>
                    </li>
                    <li role="presentation">
                        <label class="checkbox-inline">
                        <input type="checkbox" name="restore" checked>
                        restore
                        </label>
                    </li>
                    <li role="presentation">
                        <label class="checkbox-inline">
                        <input type="checkbox" name="checkCrossOrigin" checked>
                        checkCrossOrigin
                        </label>
                    </li>
                    <li role="presentation">
                        <label class="checkbox-inline">
                        <input type="checkbox" name="checkOrientation" checked>
                        checkOrientation
                        </label>
                    </li>
                    <li role="presentation">
                        <label class="checkbox-inline">
                        <input type="checkbox" name="modal" checked>
                        modal
                        </label>
                    </li>
                    <li role="presentation">
                        <label class="checkbox-inline">
                        <input type="checkbox" name="guides" checked>
                        guides
                        </label>
                    </li>
                    <li role="presentation">
                        <label class="checkbox-inline">
                        <input type="checkbox" name="center" checked>
                        center
                        </label>
                    </li>
                    <li role="presentation">
                        <label class="checkbox-inline">
                        <input type="checkbox" name="highlight" checked>
                        highlight
                        </label>
                    </li>
                    <li role="presentation">
                        <label class="checkbox-inline">
                        <input type="checkbox" name="background" checked>
                        background
                        </label>
                    </li>
                    <li role="presentation">
                        <label class="checkbox-inline">
                        <input type="checkbox" name="autoCrop" checked>
                        autoCrop
                        </label>
                    </li>
                    <li role="presentation">
                        <label class="checkbox-inline">
                        <input type="checkbox" name="movable" checked>
                        movable
                        </label>
                    </li>
                    <li role="presentation">
                        <label class="checkbox-inline">
                        <input type="checkbox" name="rotatable" checked>
                        rotatable
                        </label>
                    </li>
                    <li role="presentation">
                        <label class="checkbox-inline">
                        <input type="checkbox" name="scalable" checked>
                        scalable
                        </label>
                    </li>
                    <li role="presentation">
                        <label class="checkbox-inline">
                        <input type="checkbox" name="zoomable" checked>
                        zoomable
                        </label>
                    </li>
                    <li role="presentation">
                        <label class="checkbox-inline">
                        <input type="checkbox" name="zoomOnTouch" checked>
                        zoomOnTouch
                        </label>
                    </li>
                    <li role="presentation">
                        <label class="checkbox-inline">
                        <input type="checkbox" name="zoomOnWheel" checked>
                        zoomOnWheel
                        </label>
                    </li>
                    <li role="presentation">
                        <label class="checkbox-inline">
                        <input type="checkbox" name="cropBoxMovable" checked>
                        cropBoxMovable
                        </label>
                    </li>
                    <li role="presentation">
                        <label class="checkbox-inline">
                        <input type="checkbox" name="cropBoxResizable" checked>
                        cropBoxResizable
                        </label>
                    </li>
                    <li role="presentation">
                        <label class="checkbox-inline">
                        <input type="checkbox" name="toggleDragModeOnDblclick" checked>
                        toggleDragModeOnDblclick
                        </label>
                    </li>
                </ul>
            </div>
            <!-- /.dropdown -->
            
        </div>
        <!-- /.docs-toggles -->
    </div>
</div>
<!-- /image cropping -->