(function ($) {
    $.fn.slidemeister = function ($propertySelector, $properties) {

        var ctrlDown = false,
            ctrlKey = 17,
            cmdKey = 91,
            vKey = 86,
            cKey = 67;

        $(document).keydown(function (e) {
            if (e.keyCode == ctrlKey || e.keyCode == cmdKey) ctrlDown = true;
        }).keyup(function (e) {
            if (e.keyCode == ctrlKey || e.keyCode == cmdKey) ctrlDown = false;
        });

        var $target = this;

        var $debug = false;

        var $editorLibrary = 'medium';

        var $editors = {};

        var $elements = [];

        var $activeEditors = [];

        var $elementData = {};

        var $placeholderData = {};

        var $layersSelector = '';
        var $layersContainer = '';

        if ($properties == undefined) {
            $properties = {};
        }

        if ($propertySelector == undefined) {
            $propertySelector = '#slidemeister-properties';
        }

        if ($layersSelector == undefined) {
            $layersSelector = '#slidemeister-layers';
        }

        if ($layersContainer == undefined) {
            $layersContainer = '#slidemeister-layers-container';
        }

        var $disableHover = false;

        var $historyLock = false;

        var $tabindex = 0;

        var $editable = true;

        var slidemeister = {element: {}, ui: {}, data: {}, tab: {}, history: {}, layer: {}};

        slidemeister.data.removePreviewElements = function() {
            $($target).css('background-color', 'transparent');
            $.each($elements, function(index, e) {
                if ($elementData[e].visibility == 'preview') {
                    $($target).find('.'+e).css('display', 'none');
                }
            });
        };

        slidemeister.data.export = function (version, key) {
            $($target).css('border', 'none');
            $($target).css('zoom', '2');

            $.each($elements, function(index, e) {
                slidemeister.ui.resizeText(e, true);
            });

            if (version == 'final') {
                $($target).css('background-color', 'transparent');
                $.each($elements, function(index, e) {
                   if ($elementData[e].visibility == 'preview') {
                       $($target).find('.'+e).css('display', 'none');
                   }
                });

            }

            return domtoimage.toPng(document.getElementById($($target).prop('id')), {
                width: $($target).css('width').replace('px', '')*2,
                height: $($target).css('height').replace('px', '')*2
            })
                .then(function (png) {
                    $($target).css('border', '1px solid black');
                    $($target).css('display', 'none');

                    if (version == 'final') {

                    }

                    return [version, key, png];
                });
        };

        /**
         * Load json template from disk
         *
         * @param template
         */
        slidemeister.data.load = function (data, placeholderData = [], editable = true, preview = true) {

            slidemeister.setPlaceholderData(placeholderData);


            if ($debug == true) {
                console.log('Data loaded successfully!');
            }

            $editable = editable;

            // Get screenwidth/height for denormalizing purposes
            screenWidth = $($target).width();
            screenHeight = $($target).height();

            // Clear container and reset all class variables
            $($target).html('');
            $('#slidemeister-layers').html('');
            $editors = {};
            $elements = [];
            $elementData = {};

            // Loop through the elements in the json file
            $.each(data, function (element, values) {

                if (element == 'global') {
                    // Populate globals
                    $elementData['global'] = {};

                    $('#zoom').val(values.zoom);
                    $('#bgImage').val(values.bgImage);
                    slidemeister.element.populateDataAttributes('global', {
                        zoom: values.zoom,
                        bgImage: values.bgImage
                    });
                } else {
                    // Denormalize coordinates
                    values.x = slidemeister.data.denormalizeNumber(values.x, screenWidth);
                    values.y = slidemeister.data.denormalizeNumber(values.y, screenWidth);
                    values.width = slidemeister.data.denormalizeNumber(values.width, screenWidth);
                    values.height = slidemeister.data.denormalizeNumber(values.height, screenWidth);
                    values.fontSize = slidemeister.data.denormalizeNumber(values.fontSize, screenWidth);
                    values.actualCssFontSize = slidemeister.data.denormalizeNumber(values.actualCssFontSize, screenWidth);

                    // Check render method and create element, if applicable
                    if (preview || (!preview && values.visibility == 'render')) {
                        slidemeister.element.create(element, values, editable);
                    }
                }
            });

            // populate Data if possible
            if (!$editable) {
                setTimeout(function () {
                    slidemeister.element.replacePlaceholders();
                }, 100);

            }
        };

        /**
         * Save json template to disk
         *
         * */
        slidemeister.data.save = function (replace=false) {

            var dataToSave = {};
            dataToSave.global = {
                bgImage: $('#bgImage').val(),
                zoom: $('#zoom').val()
            };

            // Loop through element stack
            $.each($elements, function (index, element) {
                dataToSave[element] = slidemeister.data.getPropertiesFromElement(element);
                dataToSave[element].actualCssFontSize = $($target).find('.' + element).css('font-size').replace('px', '');
            });

            // Normalize coordinates
            screenWidth = $($target).width();
            screenHeight = $($target).height();

            $.each(dataToSave, function (element, data) {
                if (element != 'global') {
                    data.x = slidemeister.data.normalizeNumber(data.x, screenWidth, 10);
                    data.y = slidemeister.data.normalizeNumber(data.y, screenWidth, 10);
                    data.width = slidemeister.data.normalizeNumber(data.width, screenWidth, 10);
                    data.height = slidemeister.data.normalizeNumber(data.height, screenWidth, 10);
                    data.fontSize = slidemeister.data.normalizeNumber(data.fontSize, screenWidth, 10);
                    data.actualCssFontSize = slidemeister.data.normalizeNumber(data.actualCssFontSize, screenWidth, 10);
                    if (replace) {
                        data.text = $($target).find('.' + element + ' span').html();
                        data.color = $($target).find('.' + element).css('color');
                    }
                }
            });

            return dataToSave;
        };

        slidemeister.data.normalizeNumber = function (n1, n2, decimals) {
            if (n2 == 0) {
                return 0;
            }

            return Number((n1 / n2).toFixed(decimals));
        };

        slidemeister.data.denormalizeNumber = function (n1, n2, decimals) {
            if (n2 == 0) {
                return 0;
            }

            return Number((n1 * n2).toFixed(decimals));
        };

        /**
         * Get all properties from an element and return it as hash
         *
         * @param element
         * @returns {{}}
         */
        slidemeister.data.getPropertiesFromElement = function (element) {

            var elementData = {};
            // Get properties and values for each element
            $.each($properties, function (property, data) {
                if (data.elementProperty !== false) {
                    elementData[property] = $elementData[element][property];
                    //elementData[property] = $($target).find('.' + element).data(property);
                }
            });


            return elementData;
        };

        slidemeister.data.populateTimetable = function (data) {
            setTimeout(function () {
                var baseTimeElement, baseTypeElement, baseNameElement = false;

                $.each($elements, function (index, element) {
                    if ($elementData[element].prettyname == 'timetable_time') {
                        baseTimeElement = element;
                    }
                    if ($elementData[element].prettyname == 'timetable_event_type') {
                        baseTypeElement = element;
                    }
                    if ($elementData[element].prettyname == 'timetable_event_name') {
                        baseNameElement = element;
                    }
                });

                var height = $($target).find('.'+baseNameElement+ ' div').height();

                $.each(data, function (index, row) {
                    if (index == 0) {
                        timeElement = baseTimeElement;
                        typeElement = baseTypeElement;
                        nameElement = baseNameElement;
                    } else {
                        timeElement = slidemeister.element.clone(baseTimeElement, 0, index*height, false);
                        typeElement = slidemeister.element.clone(baseTypeElement, 0, index*height, false);
                        nameElement = slidemeister.element.clone(baseNameElement, 0, index*height, false);
                    }

                    time = '';
                    if (index == 0 || data[index-1].time != row.time) {
                        time = row.time;
                    }
                    $($target).find('.'+timeElement+ ' span').html(time);

                    $($target).find('.'+typeElement+ ' span').html(row.type);
                    $($target).find('.'+typeElement).css('color', row.color);
                    $($target).find('.'+nameElement+ ' span').html(row.name);
                    slidemeister.ui.resizeText(nameElement, true);
                });
            }, 100);
        };

        slidemeister.data.populatePrizegiving = function (data, metaElement, showRank) {
            setTimeout(function () {
                var baseAuthorElement, baseRankElement = false;

                $.each($elements, function (index, element) {
                    if ($elementData[element].prettyname == 'prizegiving_author') {
                        baseAuthorElement = element;
                    }
                    if ($elementData[element].prettyname == 'prizegiving_rank') {
                        baseRankElement = element;
                    }
                });

                var height = $($target).find('.'+baseAuthorElement+ ' div').height();


                var normalized = [];
                $.each(data, function (index, row) {
                    // console.log(index+' - '+height);
                    if (index < 7) {
                        if (index == 0) {
                            authorElement = baseAuthorElement;
                            rankElement = baseRankElement;
                        } else {
                            authorElement = slidemeister.element.clone(baseAuthorElement, 0, index*(height*1.20), false);
                            rankElement = slidemeister.element.clone(baseRankElement, 0, index*(height*1.20), false);
                        }

                        $($target).find('.'+authorElement+ ' span').html(row.title+' by '+row.author);
                        if (showRank != undefined) {
                            $($target).find('.'+rankElement+ ' span').html('#'+row.rank);
                        } else {
                            $($target).find('.'+rankElement+ ' span').html(' ');

                            var width = $($target).find('.'+authorElement).outerWidth();

                            // var x1 = $elementData[rankElement].x;
                            var x1 = parseInt($($target).find('.'+authorElement).css('left').replace('px', ''));
                            // var y1 = $elementData[rankElement].y;
                            var y1 = parseInt($($target).find('.'+authorElement).css('top').replace('px', ''))-(height/2);

                            if (row.max_points == 0) {
                                var x2 = x1;
                            } else {
                                var x2 = Math.max(((row.points / row.max_points) * width) + x1, x1);
                            }

                            var y2 = y1+height;

                            // console.log(x1 + ', ' + x2 + ', ' + y1 + ', ' + y2);

                            normalized.push({
                                x1: slidemeister.data.normalizeNumber(x1, $($target).width(), 4),
                                x2: slidemeister.data.normalizeNumber(x2, $($target).width(), 4),
                                y1: slidemeister.data.normalizeNumber(y1, $($target).height(), 4),
                                y2: slidemeister.data.normalizeNumber(y2, $($target).height(), 4)
                            });

                            if (metaElement != undefined && metaElement != '') {
                                $('input[name="'+metaElement+'"]').val(JSON.stringify(normalized));
                            }

                            // var x1 = slidemeister.data.normalizeNumber(x1, 1920, 4);
                            // var x2 = slidemeister.data.normalizeNumber(x2, 1920, 4);
                            //
                            // var y1 = slidemeister.data.normalizeNumber(y1, 1920, 4);
                            // var y2 = slidemeister.data.normalizeNumber(y2, 1920, 4);


                            // $entry->x2 = normalize_number(@max((($entry->points / $max_points) * $this->width) - $x, $x), $this->width);

                            // $entry->y1 = normalize_number($entry_block['y'] + $y - 60, $this->height);
                            // $entry->y2 = normalize_number($entry_block['y'] + $y + 13, $this->height);











                        }
                        slidemeister.ui.resizeText(authorElement, true);
                    }
                });
            }, 100);
        };

        /**
         * Set placeholderdata
         *
         * @param placeholderData
         */
        slidemeister.setPlaceholderData = function (placeholderData) {
            $placeholderData = placeholderData;
        };

        /**
         * Replace the placeholders
         */
        slidemeister.element.replacePlaceholders = function () {
            $.each($elements, function (index, element) {
                var placeholderTemplate = $elementData[element].placeholder;
                if (placeholderTemplate != '') {
                    $.each($placeholderData, function (placeholder, value) {
                        placeholderTemplate = placeholderTemplate.replace('{{' + placeholder + '}}', value);
                    });
                    // Replace remaining placeholders
                    placeholderTemplate = placeholderTemplate.replace(/\{\{(.*)\}\}/, '');
                    if (placeholderTemplate != '') {
                        $($target).find('.' + element + ' span').html(placeholderTemplate);
                        slidemeister.ui.resizeText(element, true);
                    }
                }
            });
        };

        /**
         * Create a new randomly generated unique element id (not really unique but you know... time)
         *
         * @returns {string}
         */
        slidemeister.element.getUniqeId = function () {
            return 'element_' + Math.floor((Math.random() * 100000000) + 1);
        };

        /**
         * Create a new slidemeister image element
         *
         * @param url
         */
        slidemeister.element.createImage = function (url) {
            var data = slidemeister.element.defaultValues();

            element = data[0];
            values = data[1];
            values.text = '';
            values.image = url;

            slidemeister.element.create(element, values);
        };

        /**
         * Create default values for a new element
         *
         * @returns {*[]}
         */
        slidemeister.element.defaultValues = function () {
            values = {};
            // Assign default values
            $.each($properties, function (property, data) {
                if (data.globalProperty == undefined) {
                    values[property] = data.default;
                }
            });

            // get highest z-index
            var zIndex = 0;
            $('.slidemeister-element').each(function (index, item) {
                var value = parseInt($(item).css('z-index'));

                zIndex = (value > zIndex) ? value : zIndex;
            });

            zIndex += 10;

            values['zIndex'] = zIndex;

            element = slidemeister.element.getUniqeId();
            values.element = element;

            return [element, values];
        };

        /**
         * Create a new slidemeister-element
         *
         * @param element
         * @param values
         */
        slidemeister.element.create = function (element, values, editable = true) {

            if (element == undefined) {
                var data = slidemeister.element.defaultValues();

                element = data[0];
                values = data[1];
            }

            // Add new element to stack
            $elements.push(element);
            $elementData[element] = {};

            if ($debug == true) {
                console.log('Created element ' + element);
            }

            // Inject html
            $($target).append('<div class="' + element + ' slidemeister-element" data-element="' + element + '"><p class="draghandle invisible"></p><div><span style="display: block;"></span></div></div>');

            // Populate, if values are supplied
            if (values != undefined) {
                slidemeister.element.populateDataAttributes(element, values);

                // Set css font-size to actual size
                if (values.actualCssFontSize != undefined && values.actualCssFontSize > 0) {
                    $($target).find('.' + element).css('font-size', values.actualCssFontSize + 'px');
                }
            }

            // Add events
            $(document).keydown(function (e) {
                if ($historyLock) {
                    return;
                }

                if (e.which === 90 && (e.ctrlKey || e.metaKey) && e.shiftKey) {
                    if ($debug) {
                        console.log('Redo');
                    }
                    slidemeister.history.forward();
                    $historyLock = true;
                    window.setTimeout(function () {
                        $historyLock = false;
                    }, 250);
                }
                else if (e.which === 90 && (e.ctrlKey || e.metaKey)) {
                    if ($debug) {
                        console.log('Undo');
                    }
                    slidemeister.history.back();
                    $historyLock = true;
                    window.setTimeout(function () {
                        $historyLock = false;
                    }, 250);
                }
            });

            // Clicking on an element should populate the property form fields with the current values
            if ($editable) {
                $($target).find('.' + element).on('click', function () {
                    slidemeister.ui.populatePropertyFormFields(element);
                    $('.slidemeister-element').removeClass('active');
                    $($target).find('.' + element).addClass('active');
                    //updateValues(this.id); // is this still necessary?
                });
            }

            // Hovering over an element should display the bounding box
            $($target).find('.' + element).mouseover(function () {
                // don't add the hover class, if we're actively editing that content
                if ($activeEditors[$(this).data('element')] === true || $disableHover) {
                    return;
                }
                // $('.slidemeister-element').addClass('slidemeister-element-mouseover');

                if (editable) {
                    $('.slidemeister-element').find('.ui-resizable-handle').addClass('invisible');
                    $('.slidemeister-element').find('.ui-rotatable-handle').addClass('invisible');
                    $('.slidemeister-element').find('.draghandle').addClass('invisible');

                    $(this).find('.ui-resizable-handle').removeClass('invisible');
                    $(this).find('.ui-rotatable-handle').removeClass('invisible');
                    $(this).find('.draghandle').removeClass('invisible');

                    $(this).removeClass('slidemeister-element-mouseover');
                    $(this).addClass('slidemeister-element-mouseover-highlight');
                }


                $('#slidemeister-layers li[data-name="' + element + '"]').css('background-color', '#aaa');

            });

            // Unhovering over an element should remove the display of the bounding box
            $($target).find('.' + element).mouseout(function () {
                if ($disableHover) {
                    return;
                }
                $('.slidemeister-element').removeClass('slidemeister-element-mouseover');
                $('.slidemeister-element').find('.ui-resizable-handle').addClass('invisible');
                $('.slidemeister-element').find('.ui-rotatable-handle').addClass('invisible');
                $('.slidemeister-element').find('.draghandle').addClass('invisible');
                $(this).removeClass('slidemeister-element-mouseover-highlight');

                $('#slidemeister-layers li[data-name="' + element + '"]').css('background-color', '');
            });

            if ($debug == true) {
                console.log("Create editor for " + element);
            }

            var initializeEditor = function () {

                if ($elementData[element].editable == '0') {
                    return;
                }

                $(this).addClass('active');
                if (editable) {
                    if ($(this).data('ui-draggable')) {
                        $(this).draggable("option", "handle", "p.draghandle");
                    }
                }

                if ($debug) {
                    console.log("Focus element and create editor" + element);
                }

                $(this).removeClass('slidemeister-element-mouseover');

                // unbind dblclick method
                $(this).off('dblclick');


                if ($editorLibrary == 'medium') {
                    if ($editors[element]) {
                        $editors[element].setup();
                    } else {
                        $editors[element] = new MediumEditor('.' + element + ' span', {
                            // paste: false,
                            paste: {
                                cleanPastedHTML: true,
                            },
                            toolbar: false,
                            placeholder: {
                                text: ''
                            },
                            // extensions: {
                            //     'fontSize': new MediumInput({
                            //         type: 'text',
                            //         class: '',
                            //         value: $elementData[element].fontSize,
                            //         action: function (parent, value) {
                            //             var element = $(parent).parentsUntil('.slidemeister-element').parent()[0];
                            //             $(element).css('font-size', value);
                            //             slidemeister.element.populateDataAttributes($(element).prop('id'), {'fontSize': value});
                            //             slidemeister.ui.populatePropertyFormFields($(element).prop('id'));
                            //         }
                            //     }),
                            //     'fontColor': new MediumInput({
                            //         type: 'hidden',
                            //         class: 'color-picker hidden',
                            //         value: $elementData[element].color,
                            //         action: function (parent, value) {
                            //             var element = $(parent).parentsUntil('.slidemeister-element').parent()[0];
                            //             $(element).css('color', value);
                            //             slidemeister.element.populateDataAttributes($(element).prop('id'), {'color': value});
                            //             slidemeister.ui.populatePropertyFormFields($(element).prop('id'));
                            //         }
                            //     }),
                            //     'fontFamily': new MediumSelect({
                            //         options: [
                            //             {name: 'Verdana', value: 'Verdana'},
                            //             {name: 'Arial', value: 'Arial'},
                            //             {name: 'Exo', value: 'Exo'}
                            //         ],
                            //         action: function (parent, value) {
                            //             var element = $(parent).parentsUntil('.slidemeister-element').parent()[0];
                            //             $(element).css('font-family', value);
                            //             slidemeister.element.populateDataAttributes($(element).prop('id'), {'fontFamily': value});
                            //             slidemeister.ui.populatePropertyFormFields($(element).prop('id'));
                            //         }
                            //     }),
                            //     'alignLeft': new MediumButton({
                            //         label: '<i class="fa fa-align-left"></i>',
                            //         action: function (html, mark, parent) {
                            //             var element = $(parent).parentsUntil('.slidemeister-element').parent()[0];
                            //             $(element).css('text-align', 'left');
                            //             slidemeister.element.populateDataAttributes($(element).prop('id'), {'textAlign': 'left'});
                            //             slidemeister.ui.populatePropertyFormFields($(element).prop('id'));
                            //             return html
                            //         }
                            //     }),
                            //     'alignCenter': new MediumButton({
                            //         label: '<i class="fa fa-align-center"></i>',
                            //         action: function (html, mark, parent) {
                            //             var element = $(parent).parentsUntil('.slidemeister-element').parent()[0];
                            //             $(element).css('text-align', 'center');
                            //             slidemeister.element.populateDataAttributes($(element).prop('id'), {'textAlign': 'center'});
                            //             slidemeister.ui.populatePropertyFormFields($(element).prop('id'));
                            //             return html
                            //         }
                            //     }),
                            //     'alignRight': new MediumButton({
                            //         label: '<i class="fa fa-align-right"></i>',
                            //         action: function (html, mark, parent) {
                            //             var element = $(parent).parentsUntil('.slidemeister-element').parent()[0];
                            //             $(element).css('text-align', 'right');
                            //             slidemeister.element.populateDataAttributes($(element).prop('id'), {'textAlign': 'right'});
                            //             slidemeister.ui.populatePropertyFormFields($(element).prop('id'));
                            //             return html
                            //         }
                            //     })
                            // }
                        });
                    }

                    $activeEditors[element] = true;

                    $editors[element].subscribe('positionToolbar', function (e) {
                        $('.color-picker').minicolors({
                            format: 'rgb',
                            opacity: true,
                            position: 'bottom right'
                        });
                    });

                    $editors[element].subscribe('blur', function (data, editable) {

                        // Only destroy editor if it's a NON copy/paste action
                        if (ctrlDown) {
                            console.log('Ctrl key is currently down - refocus element');
                            return false;
                        }


                        // Get text
                        var text = $(editable).html();

                        // Set the new text value in the form field
                        $('#text').val(text);

                        // Save old field data
                        var oldText = $elementData[element].text;

                        if (oldText != text) {
                            slidemeister.history.save();
                        }

                        // Update data attributes and css
                        slidemeister.element.populateDataAttributes(element, {text: text});


                        if ($debug) {
                            console.log("Destroy editor for " + element);
                        }
                        $editors[element].destroy();
                        $($target).find('.' + element).removeClass('active');

                        if ($($target).find('.' + element).data('ui-draggable')) {
                            $($target).find('.' + element).draggable("option", "handle", false);
                        }

                        // bind dblclick again
                        $($target).find('.' + element).on('dblclick', initializeEditor);

                        delete $activeEditors[element]
                        // delete $editors[element];
                    });

                    $editors[element].subscribe('editableInput', function (data, editable) {
                        slidemeister.ui.resizeText(element);
                    });

                    // highlight text and activate editor
                    $($target).find('.' + element).selectText();
                }
            };

            if (editable) {
                $($target).find('.' + element).on('dblclick', initializeEditor);
            }

            // Get current rotation from css
            var tr = $($target).find('.' + element).css('transform');

            var degrees = 0;
            if (tr != undefined && tr != 'none' && tr.split('(').length > 0) {
                var values = tr.split('(')[1],
                    values = values.split(')')[0],
                    values = values.split(',');

                degrees = Math.round(Math.asin(values[1]) * (180 / Math.PI))
            }

            if (editable) {
                $($target).find('.' + element).resizable(
                    {
                        containment: $('#slidemeister-canvas'),
                        create: function (event, ui) {
                            // $(event.target).find('.ui-resizable-se').removeClass('ui-icon ui-icon-gripsmall-diagonal-se');
                            // $(event.target).find('.ui-resizable-se').addClass('fa fa-expand fa-rotate-90');
                        },
                        start: function () {
                            $disableHover = true;
                            $elementData[$(this).data('element')].size = 'Individual';
                            slidemeister.element.populateDataAttributes($(this).data('element'), {size: 'Individual'}, false);
                        },
                        stop: function () {
                            slidemeister.ui.updateDragResize($(this).data('element'));
                            $disableHover = false;
                        },
                        //grid: [5, 5],
                        minWidth: -($($target).width()) * 10,  // these need to be large and negative
                        minHeight: -($($target).height()) * 10, // so we can shrink our resizable while scaled
                        resize: slidemeister.ui.fixResizableWithCssZoom,
                    }
                ).draggable(
                    {
                        // handle: 'p.draghandle',
                        containment: 'none',
                        cursor: 'move',
                        start: function (event, ui) {
                            $disableHover = true;

                            // Fix issue when the draggable is rotated
                            var left = parseInt($(this).css('left'), 10);
                            left = isNaN(left) ? 0 : left;
                            var top = parseInt($(this).css('top'), 10);
                            top = isNaN(top) ? 0 : top;
                            recoupLeft = left - ui.position.left;
                            recoupTop = top - ui.position.top;

                            $elementData[$(this).data('element')].size = 'Individual';
                            slidemeister.element.populateDataAttributes($(this).data('element'), {size: 'Individual'}, false);
                        },
                        stop: function (event, ui) {
                            $disableHover = false;
                            slidemeister.ui.updateDragResize($(this).data('element'));
                        },
                        //grid: [5, 5],
                        zIndex: 1000000,
                        drag: function (event, ui) {
                            slidemeister.ui.fixDraggableWithCssZoom(event, ui, recoupLeft, recoupTop);
                        },
                        snap: '.slidemeister-element',
                        snapTolerance: 10
                    }
                ).rotatable({
                    // Callback fired on rotation start.
                    start: function (event, ui) {
                    },
                    // Callback fired during rotation.
                    rotate: function (event, ui) {
                    },
                    // Callback fired on rotation end.
                    stop: function (event, ui) {
                        $elementData[$(this).data('element')].size = 'Individual';
                        slidemeister.element.populateDataAttributes($(this).data('element'), {size: 'Individual'}, false);
                        slidemeister.ui.updateRotate($(this).data('element'));
                    },
                    handleOffset: {
                        top: -5,
                        right: -5
                    },
                    degrees: degrees,
                    wheelRotate: false,
                    // Set the rotation center
                    // rotationCenterOffset: {
                    //     top: 20,
                    //     left: 20
                    // },
                    // transforms: {
                    //     translate: '(50%, 50%)',
                    //     scale: '(2)'
                    //     //any other transforms
                    // }
                });

                $($target).find('.' + element).find('.ui-resizable-handle').addClass('invisible');
                $($target).find('.' + element).find('.ui-rotatable-handle').addClass('invisible');
            }

            // Do an initial resize
            if (editable) {
                slidemeister.ui.resizeText(element);
            }

            // Toggle lock
            slidemeister.element.toggleLocking(element, $elementData[element].locked);

            // Add element to sortable
            slidemeister.layer.addToStack(element);

        };

        slidemeister.element.toggleLocking = function (element, value) {
            if (value == undefined) {
                return;
            }
            if ($($target).find('.' + element).data('ui-draggable')) {
                if (value == 1) {
                    $($target).find('.' + element).draggable("disable");
                    $($target).find('.' + element).rotatable("disable");
                    $($target).find('.' + element).resizable("disable");
                } else {
                    $($target).find('.' + element).draggable("enable");
                    $($target).find('.' + element).rotatable("enable");
                    $($target).find('.' + element).resizable("enable");
                }
            }
        };

        slidemeister.ui.toggleSnapping = function (value) {

            $('.slidemeister-element').each(function (index, element) {
                if ($(element).data('ui-draggable')) {
                    if (value == 1) {
                        $(element).draggable("option", "snap", true);
                    } else {
                        $(element).draggable("option", "snap", false);
                    }
                }
            });
        };

        /**
         * Change form field data (e.g. when somebody changes something manually in a form field
         *
         * @param event
         */
        slidemeister.ui.changeFormFieldData = function (event) {

            element = $('#element').val();

            if ($debug == true) {
                console.log('changeFormFieldData for element ' + element);
            }

            if (element == '') {
                element = 'global';
                if ($debug == true) {
                    console.log('empty element - let us just assume that it is "global"');
                }
            }

            property = event.currentTarget.id;

            values = {};
            values[property] = $('#' + property).val();

            slidemeister.history.save();

            slidemeister.element.populateDataAttributes(element, values);
        };

        /**
         * Populate data attributes
         *
         * @param element
         * @param values
         * @param callbacks
         */
        slidemeister.element.populateDataAttributes = function (element, values, callbacks = true) {

            if ($debug == true) {
                console.log('populateDataAttributes for ' + element);
            }

            // Populate data attributes and css values
            $.each(values, function (property, value) {

                // Break loop if we're dealing with an illegal property (e.g. after modifying the properties
                if ($properties[property] == undefined) {
                    return;
                }

                // Only update $elementData if we're not dealing with global properties
                if ($properties[property].globalProperty !== true) {
                    $elementData[element][property] = value;
                }

                // Update css properties, if necessary
                if ($properties[property].updateCss != undefined) {
                    $.each($properties[property].updateCss, function (index, cssProperty) {
                        if (cssProperty == 'font-size') {
                            value += 'px';
                        }
                        $($target).find('.' + element).css(cssProperty, value);
                    });
                }

                // Update tag attributes, if necessary
                if ($properties[property].updateAttr != undefined) {
                    $.each($properties[property].updateAttr, function (index, attr) {
                        $($target).find('.' + element).attr(attr, value);
                    });
                }

                // Add custom callback (if defined)
                if ($properties[property].callback != undefined && callbacks) {
                    $properties[property].callback(element, value, slidemeister, $target);
                }
            });
        };

        /**
         * Delete element
         */
        slidemeister.element.delete = function () {

            slidemeister.history.save();

            // Get element from form field
            element = $('#element').val();

            if ($debug == true) {
                console.log('Delete ' + element);
            }

            // Remove element from dom tree
            $($target).find('.' + element).remove();

            // Delete the element
            $.each($elements, function (index, name) {
                if (name == element) {
                    $elements.splice(index, 1);
                }
            });

            // Rebuild the layer list
            slidemeister.layer.rebuild();
        };

        /**
         * Clone element
         */
        slidemeister.element.clone = function (elementToBeCloned, x=50, y=50, editable=true) {

            // Get element
            if (elementToBeCloned == undefined) {
                elementToBeCloned = $('#element').val();
            }
            var newElement = slidemeister.element.getUniqeId();

            if ($debug == true) {
                console.log('Clone ' + elementToBeCloned);
            }

            // Get element data (cloning them, and not just referencing the object)
            var values = $.extend({}, $elementData[elementToBeCloned]);

            values.x = parseInt(values.x) + x;
            values.y = parseInt(values.y) + y;
            values.element = newElement;

            slidemeister.history.save();

            slidemeister.element.create(newElement, values, editable);

            return newElement;
        };

        /**
         * Update element (brauch ich garnicht!)
         */
        slidemeister.element.update = function () {
        };

        slidemeister.layer.rebuild = function () {
            slidemeister.layer.removeAll();
            $.each($elements, function (index, element) {
                slidemeister.layer.addToStack(element);
            });
        };

        slidemeister.layer.createSortable = function () {
            $('#slidemeister-layers-container').append('<ul id="slidemeister-layers" class="list-group"></ul>');

            $('#slidemeister-layers').sortable({
                stop: function (event, ui) {

                    slidemeister.history.save();

                    // Delete $elements and rebuild in the correct, new order
                    $elements = [];

                    $('#slidemeister-layers li').each(function (index, layer) {

                        element = $(layer).data('name');
                        value = 20000 + ((index * -1) * 10);

                        // Add element in the correct new order
                        $elements.push(element);

                        $($target).find('.' + element).css('z-index', value);
                        $elementData[element].zIndex = value;
                    });
                }
            });
        };

        slidemeister.layer.removeAll = function () {
            $('#slidemeister-layers').html('');
        };

        slidemeister.layer.addToStack = function (element) {
            if ($('#slidemeister-layers-container ul').find('li[data-name="' + element + '"]').length > 0) {
                return;
            }

            zIndexValue = $elementData[element]['zIndex'];

            var field = '<li class="list-group-item" data-z-index="' + zIndexValue + '" data-name="' + element + '">' + ($elementData[element]['prettyname'] ? $elementData[element]['prettyname'] : element) + '</li>';
            fieldSelector = $('#slidemeister-layers-container ul').append(field);

            // Add mouseover/mouseout events for layer items
            $('#slidemeister-layers li[data-name="' + element + '"]')
                .on('mouseover', function () {
                    $('.slidemeister-element').addClass('slidemeister-element-mouseover');
                    $($target).find('.' + $(this).data('name')).removeClass('slidemeister-element-mouseover');
                    $($target).find('.' + $(this).data('name')).addClass('slidemeister-element-mouseover-elementlist-highlight');
                })
                .on('mouseout', function () {
                    $('.slidemeister-element').removeClass('slidemeister-element-mouseover');
                    $($target).find('.' + $(this).data('name')).removeClass('slidemeister-element-mouseover-elementlist-highlight');
                })
                .on('click', function () {
                    $($target).find('.' + $(this).data('name')).click();
                });

            slidemeister.ui.resort();

        };

        slidemeister.ui.resort = function () {
            // resort list by zIndex
            var list = $('#slidemeister-layers');
            var items = list.children('li').get();
            items.sort(function (a, b) {
                var compA = parseInt($(a).data('z-index'));
                var compB = parseInt($(b).data('z-index'));
                return (compA > compB) ? -1 : (compA < compB) ? 1 : 0;
            });
            $.each(items, function (index, item) {
                list.append(item);
            });
        };

        /**
         * Creates form fields from the properties array
         */
        slidemeister.ui.createPropertyFormFields = function () {

            if ($debug == true) {
                console.log('createPropertyFormFields');
            }

            // Generate property input fields
            $.each($properties, function (property, data) {
                var addStyle = '';
                if (data.visible === false) {
                    addStyle = 'display: none;';
                }
                var field = '<div class="input-group slidemeister-property-list" style="' + addStyle + '"><label class="col-form-label col-form-label-sm" for="' + property + '">' + property + '</label>';

                switch (data.type) {
                    case 'select':
                        field += '<select class="form-control form-control-sm" id="' + property + '" name="' + property + '" value="' + data.default + '">';
                        $.each(data.options, function (name, value) {
                            field += '<option value="' + value + '">' + name + '</option>';
                        });
                        field += '</select>';
                        break;
                    case 'textarea':
                        field += '<textarea class="form-control form-control-sm" id="' + property + '" name="' + property + '">' + data.default + '</textarea></>';
                        break;
                    case 'text':
                        field += '<input class="form-control form-control-sm" id="' + property + '" type="text" name="' + property + '" value="' + data.default + '"/></>';
                        break;
                    case 'color':
                        field += '<input class="form-control form-control-sm color-picker" id="' + property + '" type="text" name="' + property + '" value="' + data.default + '"/></>';
                        break;
                    default:
                        break;
                }
                field += '</div>';
                $($propertySelector).append(field);
                $('.color-picker').minicolors({
                    format: 'rgb',
                    opacity: true,
                    position: 'bottom right'
                });

                // Add callbacks for property changes
                $('#' + property).on('change', slidemeister.ui.changeFormFieldData);

                $('#' + property).on('focus', slidemeister.tab.setIndex);
            });

            // Build sortable list stub for layers
            slidemeister.layer.createSortable();
        };

        /**
         * Update x/y/w/h values from draggable/resizable
         *
         * @param element
         */
        slidemeister.ui.updateDragResize = function (element) {

            if ($debug == true) {
                console.log('updateDragResize for ' + element);
            }

            slidemeister.history.save();

            // Update data attributes

            // Compensate for rotation
            var left = parseInt($($target).find('.' + element).css('left'), 10);
            left = isNaN(left) ? 0 : left;
            var top = parseInt($($target).find('.' + element).css('top'), 10);
            top = isNaN(top) ? 0 : top;
            recoupLeft = left;
            recoupTop = top;
            -$($target).find('.' + element).offset().top;


            $elementData[element].x = Math.round(recoupLeft);
            $elementData[element].y = Math.round(recoupTop);

            // $elementData[element].x = Math.round($($target).find('.' + element).offset().left);
            // $elementData[element].y = Math.round($($target).find('.' + element).offset().top);

            $elementData[element].width = $($target).find('.' + element).css('width').replace('px', '');
            $elementData[element].height = $($target).find('.' + element).css('height').replace('px', '');

            // $elementData[element].width = Math.round($($target).find('.' + element).width());
            // $elementData[element].height = Math.round($($target).find('.' + element).height());

            // Update form field values
            slidemeister.ui.populatePropertyFormFields(element);

            // Update text
            slidemeister.ui.resizeText(element);

            // Update images
            slidemeister.ui.updateImages(element);
        };

        /**
         * Update rotation values from rotatable
         *
         * @param element
         */
        slidemeister.ui.updateRotate = function (element) {

            if ($debug == true) {
                console.log('updateRotate for ' + element);
            }

            slidemeister.history.save();

            // Update data attributes
            $elementData[element].rotation = $($target).find('.' + element).css('transform');

            // Update form field values
            slidemeister.ui.populatePropertyFormFields(element);
        };

        /**
         * Update the form fields to display the current data
         *
         * @param element
         */
        slidemeister.ui.populatePropertyFormFields = function (element) {

            if ($debug == true) {
                console.log('populatePropertyFormFields for ' + element);
            }

            // Update the form fields to display the actual data
            $.each($properties, function (property, data) {
                if (data != undefined && data.updateDataAttribute === true) {
                    //$('#' + property).val($($target).find('.' + element).data(property));
                    $('#' + property).val($elementData[element][property]);
                }
            });
        };

        /**
         * Update image elements by setting background images and other css attributes
         *
         * @param element
         */
        slidemeister.ui.updateImages = function (element) {

            if ($debug == true) {
                console.log('updateImages for ' + element);
            }

            $($target).find('.' + element + ' span').html($elementData[element].text);
            slidemeister.ui.resizeText(element);

            if ($elementData[element].image != undefined && $elementData[element].image != '') {
                $($target).find('.' + element).css('background-image', 'url(' + $elementData[element].image + ')');
            } else {
                $($target).find('.' + element).css('background-image', '');
            }
        };

        slidemeister.ui.toggleFullScreenImage = function (element, value) {
            if (value == 'Fill') {
                $elementData[element].x = -4;
                $elementData[element].y = -4;

                $elementData[element].width = 966;
                $elementData[element].height = 546;
                $elementData[element].rotation = '';

                slidemeister.element.populateDataAttributes(element, $elementData[element], false);
            }
        };

        /**
         * Resize font-size according to the maximum available width and height of the element
         *
         * @param element
         * @param elementWidth
         * @param elementHeight
         */
        slidemeister.ui.resizeText = function (element, force = false, elementWidth, elementHeight) {

            if ($debug == true) {
                console.log('resizeText for ' + element);
            }

            if (force == false && (element == '' || !$editable)) {
                return;
            }


            var fontSize = parseInt($($target).find('.' + element).attr('font-size'));

            var textHeight = $($target).find('.' + element + ' div span').outerHeight();
            var textWidth = $($target).find('.' + element + ' div span').outerWidth();

            // For live-text scaling wile resizing the element when operating on a zoomed target...
            if (elementWidth == undefined && elementHeight == undefined) {
                var elementHeight = $($target).find('.' + element).outerHeight();
                var elementWidth = $($target).find('.' + element).outerWidth();
            }

            // Inflate text if necessary
            cssFontSize = parseInt($($target).find('.' + element).css('font-size'), 10);
            while (textHeight <= elementHeight && textWidth <= elementWidth && fontSize > cssFontSize) {
                cssFontSize++;

                $($target).find('.' + element).css({'font-size': cssFontSize + 'px'});
                textHeight = $($target).find('.' + element + ' div span').outerHeight();
                textWidth = $($target).find('.' + element + ' div span').outerWidth();

                cssFontSize = parseInt($($target).find('.' + element).css('font-size'), 10);
            }

            // console.log('Element: ' + element + ', Textheight: ' + textHeight + ', Textwidth: ' + textWidth + ', Elementheight: ' + elementHeight + ', Fontsize: ' + fontSize + ', Text: ' + $($target).find('.' + element + ' span').html());

            // Shrink text if necessary (ignore width for now as it seems to make huge problems with jquery.ui.resizable when in a zoomed context (yay)
            while ((textHeight > elementHeight || textWidth > elementWidth) && fontSize > 5) { //} || textWidth > elementWidth) && fontSize > 10) { // define minimum fontsize
                fontSize--;
                $($target).find('.' + element).css({'font-size': fontSize + 'px'});
                // $($target).find('.' + element).attr('font-size', fontSize+'px');
                textHeight = $($target).find('.' + element + ' div span').outerHeight();
                textWidth = $($target).find('.' + element + ' div span').outerWidth();

                // console.log('Element: ' + element + ', Textheight: ' + textHeight + ', Textwidth: ' + textWidth + ', Elementheight: ' + elementHeight + ', Fontsize: ' + fontSize);
                // console.log('CLIENT HEIGHT: '+ $($target).find('.' + element)[0].clientHeight);
                // console.log('SCROLL HEIGHT: '+ $($target).find('.' + element)[0].scrollHeight);
            }
        };

        /**
         * fix jQuery UI with css zoom property when resizing
         *
         * @param event
         * @param ui
         */
        slidemeister.ui.fixResizableWithCssZoom = function (event, ui) {

            if ($debug == true) {
                console.log('fixResizableWithCssZoom');
            }

            var zoomScale = $($target).css('zoom');
            var changeWidth = ui.size.width - ui.originalSize.width; // find change in width
            var newWidth = ui.originalSize.width + changeWidth / zoomScale; // adjust new width by our zoomScale

            var changeHeight = ui.size.height - ui.originalSize.height; // find change in height
            var newHeight = ui.originalSize.height + changeHeight / zoomScale; // adjust new height by our zoomScale

            // Don't mess it up
            if (newWidth < 20) {
                newWidth = 20;
            }
            if (newHeight < 20) {
                newHeight = 20;
            }

            ui.size.width = newWidth;
            ui.size.height = newHeight;

            slidemeister.ui.resizeText(event.target.id, false, newWidth, newHeight);
        };

        /**
         * fix jQuery UI with css zoom property when dragging
         *
         * @param event
         * @param ui
         */
        slidemeister.ui.fixDraggableWithCssZoom = function (event, ui, recoupLeft, recoupTop) {

            if ($debug == true) {
                console.log('fixDraggableWithCssZoom');
            }

            ui.position.left += recoupLeft;
            ui.position.top += recoupTop;

            var zoom = $($target).css('zoom');
            var factor = ((1 / zoom) - 1);

            // console.log(factor);

            // ui.position.top += Math.round((recoupTop - ui.originalPosition.top) * factor);
            // ui.position.left += Math.round((recoupLeft - ui.originalPosition.left) * factor);

            ui.position.top += Math.round((ui.position.top - ui.originalPosition.top) * factor);
            ui.position.left += Math.round((ui.position.left - ui.originalPosition.left) * factor);
        };

        /**
         * Get a list of all tabbable elements
         *
         * @returns {Array}
         */
        slidemeister.tab.getList = function () {
            var tablistElements = [];

            // Make list out of all tabbable elements (actual elements and form fields)
            $.each($elements, function (index, element) {
                tablistElements.push({element: element, type: 'element'});
            });
            $.each($properties, function (property, data) {
                tablistElements.push({element: property, type: 'formfield'});
            });
            return tablistElements;
        };

        /**
         * Set tabindex to the currently tabbed element
         *
         * @param event
         */
        slidemeister.tab.setIndex = function (event) {

            if ($debug == true) {
                console.log('Tab setIndex');
            }

            var tablistElements = slidemeister.tab.getList();

            element = event.currentTarget.id;

            // Find the correct tab element and set the correct index. This is necessary when manually focusing an input field
            $.each(tablistElements, function (index, tablistElement) {
                if (tablistElement.element == element) {
                    $tabindex = index;
                }
            });
        };

        /**
         * Cycle through the tablist (up/down)
         *
         * @param direction
         */
        slidemeister.tab.cycle = function (direction) {

            if ($debug == true) {
                console.log('Tab cycle');
            }

            var tablistElements = slidemeister.tab.getList();

            // Check direction and increase/decrease tabindex
            switch (direction) {
                case 'forward':
                    $tabindex++;
                    break;
                case 'back':
                    $tabindex--;
                    break;
            }

            // Reset tabindex if out of bounds
            if ($tabindex >= tablistElements.length) {
                $tabindex = 0;
            } else if ($tabindex <= -1) {
                $tabindex = (tablistElements.length) - 1;
            }

            // Get element
            element = tablistElements[$tabindex];

            // Check the element type and handle accordingly
            if (element.type == 'element') {
                // Simulate click to update form values
                $($target).find('.' + element.element).click();

                // Simulate double click to activate editor
                $($target).find('.' + element.element + ' div span').on('focus', function () {
                    $(this).selectText();
                }).focus();
            } else {
                $($target).find('.' + element.element).focus();
            }
        };

        $history = [];
        $historyIndex = 0;
        $lastHistoryAction = null;

        /**
         * Redo
         */
        slidemeister.history.forward = function () {
            if ($debug == true) {
                console.log('History forward');
            }

            // Check if there's actually a redo possible
            if ($historyIndex - 1 < 0) {
                return;
            }

            // Decrease history index and get element data
            $historyIndex--;
            elementData = $history[$historyIndex];
            $lastHistoryAction = 'redo';

            // Delete all elements and create them from scratch (?)
            $($target).html('');
            $editors = {};
            $elements = [];
            $elementData = {};

            slidemeister.layer.removeAll();

            $.each(elementData, function (element, values) {
                slidemeister.element.create(element, values);
            });

            //$.each(elementData, function(element, values) {
            //    slidemeister.element.populateDataAttributes(element, values);
            //});
        };

        /**
         * Undo
         */
        slidemeister.history.back = function () {

            if ($debug == true) {
                console.log('History back');
            }

            // Save current state if Historyindex == 0
            if ($historyIndex == 0 && $lastHistoryAction != 'redo') {
                var elementData = {};
                $.each($elements, function (index, element) {
                    elementData[element] = slidemeister.data.getPropertiesFromElement(element);
                });

                $history.unshift(elementData);
                $lastHistoryAction = 'undo';

                if ($debug == true) {
                    console.log('History back: save current state');
                }
            }

            // increase history index if possible
            if ($historyIndex + 1 >= $history.length) {
                return;
            }
            $historyIndex++;

            // Get data and populate the elements
            elementData = $history[$historyIndex];

            // FIXME can this actually happen? maybe better remove it
            if (elementData == undefined) {
                return;
            }

            // Delete all elements and create them from scratch (?)
            $($target).html('');
            $editors = {};
            $elements = [];
            $elementData = {};

            slidemeister.layer.removeAll();

            $.each(elementData, function (element, values) {
                slidemeister.element.create(element, values);
            });

            //$.each(elementData, function(element, values) {
            //    slidemeister.element.populateDataAttributes(element, values);
            //});
        };

        /**
         * Save history
         *
         * @param element
         */
        slidemeister.history.save = function () {

            if ($debug == true) {
                console.log("history save");
            }

            // Delete history items above the current index and reset the index
            for (i = 1; i < $historyIndex; i++) {
                $history.shift();
            }

            $lastHistoryAction = null;
            $historyIndex = 0;

            // Get data
            var elementData = {};
            $.each($elements, function (index, element) {
                elementData[element] = slidemeister.data.getPropertiesFromElement(element);
            });

            // Push new history to the history stack
            $history.unshift(elementData);

            // Delete old history items
            while ($history.length >= 100) {
                $history.pop();
            }
        };

        /**
         * Create the form fields from the properties array
         */
        slidemeister.ui.createPropertyFormFields();

        /**
         * Initialize tab highjacking
         */
        $(document).on('keydown', function (event) {
            if (event.shiftKey && event.keyCode == 9) { // Tab and shift pressed
                event.preventDefault();
                slidemeister.tab.cycle('back');
            } else if (event.keyCode === 9) { // Tab pressed
                event.preventDefault();
                slidemeister.tab.cycle('forward');
            }
        });

        return slidemeister;
    };
})(jQuery);

// Small jquery extension to select all text in a contenteditable element
jQuery.fn.selectText = function () {
    var doc = document;
    var element = this[0];
    if (doc.body.createTextRange) {
        var range = document.body.createTextRange();
        range.moveToElementText(element);
        range.select();
    } else if (window.getSelection) {
        var selection = window.getSelection();
        var range = document.createRange();
        range.selectNodeContents(element);
        selection.removeAllRanges();
        selection.addRange(range);
    }
};
