jQuery(document).ready(function($) {
    var abTabs = $('#abTabs');
    var aBDatePicker = $('.aBDatepicker');
    var aBTimepicker = $('.aBTimepicker');
    var aBColorpicker = $('.aBColorpicker');
    var aBUpload = $('.aBUpload');
    var abBootstrapIcons = $('.abBootstrapIcons');
    var abMagnificPopupContent = $('.open-popup-link');


    //
    // cPage tabs
    //

    $('#abTabs a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
    });

    if (aBDatePicker[0]) {
        //check if datepicker exists as a function
        if (typeof aBDatePicker.datepicker == 'function') {
            aBDatePicker.datepicker({
                dateFormat: $(self).attr('data-dateformat')
            });
        }
    }
    if (aBTimepicker[0]) {
        if (typeof aBTimepicker.timepicker == 'function') {
            aBTimepicker.timepicker();
        }
    }
    if (aBColorpicker[0]) {
        if (typeof aBColorpicker.iris == 'function') {
            aBColorpicker.iris({
                hide: true
            });
        }
    }
    if (aBUpload[0]) {
        aBUpload.click(function(e) {
            e.preventDefault();
            var xThis = $(this);

            var uploadImage = xThis.siblings('p').children(' img.uploadImage');
            var hiddenInput = xThis.siblings('input[type="hidden"]');

            if (hiddenInput.val() !== '') {
                //clear values
                console.log('clearing media uploaded values.');
                uploadImage.attr('src', '');
                hiddenInput.val('');
                xThis.html('Upload');
            } else {
                //Upload popup
                var image = wp.media({
                        title: 'Upload Image',
                        // mutiple: true if you want to upload multiple files at once
                        multiple: false
                    }).open()
                    .on('select', function(e) {
                        // This will return the selected image from the Media Uploader, the result is an object
                        var uploaded_image = image.state().get('selection').first();
                        // We convert uploaded_image to a JSON object to make accessing it easier
                        // Output to the console uploaded_image
                        console.log(uploaded_image);
                        var image_url = uploaded_image.toJSON().url;
                        console.log(image_url);
                        // Let's assign the url value to the input field
                        //  $('#image_url').val(image_url);

                        uploadImage.attr('src', image_url);
                        hiddenInput.val(image_url);
                        xThis.html('Remove');
                    });
            }



        });
    }
    var clickedIconButton = {};
    var magnicPopObj = $.magnificPopup.instance;
    if (abBootstrapIcons[0]) {
        abBootstrapIcons.click(function() {
            clickedIconButton = $(this);
            magnicPopObj.open({
                items: {
                    src: '.open-popup-link', // can be a HTML string, jQuery object, or CSS selector
                    type: 'inline'
                },
                callbacks: {
                    open: function() {
                      $('.mfp-container').addClass('ab');
                        // Will fire when this exact popup is opened
                        // this - is Magnific Popup object
                    },
                        // e.t.c.
                }
            });

        });
    }
    if (abMagnificPopupContent[0]) {
        abMagnificPopupContent.find('button').click(function() {
            var classes = $(this).children('i').attr('class').split(" ");
            var index = classes.indexOf("glyphicon");
            classes.splice(index, 1);

            clickedIconButton.html('<i class="glyphicon"></i>');
            var clickedIconButtonI = clickedIconButton.children('i');

            clickedIconButtonI.addClass(classes[0]);
            magnicPopObj.close();
            clickedIconButton.siblings('.abBIHidden').val(classes[0]);
        });
    }

    // textboxesDynamic functionality START
    var tbdAdd = $('.tbdAdd'); //add row button
    if (tbdAdd[0]) {
        tbdAdd.click(function() {
            var tbdContent = $(this).parent().siblings('.tbdContent');
            var tdOutput = $(this).parent().siblings('.tdOutput');
            tbdContentHTML = tbdContent.html();
            //get the number of dynamic field groups added
            var size = tdOutput.find('.groupContainer').size();

            var tbdContentHTMLObj = $('<div>' + tbdContentHTML + '</div>');

            //get all the inputs of the hidden html
            var dtContInputs = tbdContentHTMLObj.find('input');
            //for each input
            dtContInputs.each(function(index, i) {
                var thisInput = $(this);
                var inputAttr = thisInput.attr('dtArrName');
                if (inputAttr[0]) {
                    var thisInputName = thisInput.attr('origName');
                    var newInputName = thisInputName + '[' + size + '][' + inputAttr + ']';
                    //set the new name to the input
                    thisInput.attr('name', newInputName);
                }
            });
            // console.log(size);
            tbdContentHTML = tbdContentHTMLObj.html();
            tdOutput.append(tbdContentHTML);
        });
    }
    // close button for dynamic fields containers
    var dtClose = $('.groupContainer button.close');
    if (dtClose[0]) {
        dtClose.live('click', function() {
            var cThis = $(this); //current this
            var cc = cThis.parent().parent();
            cThis.parent().remove();
            dtGenerateNames(cc);

        });
    }

    function dtGenerateNames(parObj) {
        var groupContainers = parObj.find('.groupContainer');
        groupContainers.each(function(cIndex, i) {
            var gcThis = $(this);
            var inputs = gcThis.find('input');
            inputs.each(function(iIndex, i) {
                var iThis = $(this); //this input
                var origName = iThis.attr('origName');
                var dtArrName = iThis.attr('dtArrName');
                iThis.attr('name', origName + '[' + cIndex + '][' + dtArrName + ']');
            });
        });
    }
});
