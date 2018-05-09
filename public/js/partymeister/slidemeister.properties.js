// Define editable properties
var slidemeisterProperties = {
    element: {
        type: 'text',
        default: '',
        updateDataAttribute: true,
        visible: false
    },
    prettyname: {
        type: 'text',
        default: '',
        updateDataAttribute: true,
        callback: function (element, value, slidemeister, target) {
            $('#slidemeister-layers li[data-name="' + element + '"]').html(value);
        }
    },
    placeholder: {
        type: 'text',
        default: '',
        updateDataAttribute: true
    },
    x: {
        type: 'text',
        default: 50,
        updateCss: ['left'],
        updateDataAttribute: true,
        visible: false,
    },
    y: {
        type: 'text',
        default: 50,
        updateCss: ['top'],
        updateDataAttribute: true,
        visible: false,
    },
    width: {
        type: 'text',
        default: 200,
        updateCss: ['width'],
        updateDataAttribute: true,
        visible: false,
    },
    height: {
        type: 'text',
        default: 200,
        updateCss: ['height'],
        updateDataAttribute: true,
        visible: false,
    },
    //type: {
    //    type: 'select',
    //    options: {
    //        'text': 'text',
    //        'image': 'image'
    //    },
    //    default: 'text',
    //    updateDataAttribute: true,
    //    callback: function(element, value, slidemeister, target) {
    //        console.log("type change");
    //        slidemeister.ui.updateImages(element);
    //    }
    //},
    fontFamily: {
        type: 'select',
        options: {
            'Arial': 'Arial',
            'Verdana': 'Verdana'
        },
        default: 'Arial',
        updateCss: ['font-family'],
        updateDataAttribute: true
    },
    size: {
        type: 'select',
        options: {
            'individual': 'Individual',
            'fill': 'Fill'
        },
        default: 'individual',
        updateDataAttribute: true,
        callback: function (element, value, slidemeister, target) {
            slidemeister.ui.toggleFullScreenImage(element, value);
        }
    },
    fontSize: {
        type: 'text',
        default: 30,
        updateCss: ['font-size'],
        updateAttr: ['font-size'],
        updateDataAttribute: true,
        callback: function (element, value, slidemeister, target) {
            //console.log("fontsize change");
            slidemeister.ui.resizeText(element);
        }
    },
    fontWeight: {
        type: 'select',
        options: {
            'regular': 'normal',
            'bold': 'bold'
        },
        default: 'normal',
        updateCss: ['font-weight'],
        updateDataAttribute: true
    },
    fontStyle: {
        type: 'select',
        options: {
            'normal': 'normal',
            'italic': 'italic'
        },
        default: 'normal',
        updateCss: ['font-style'],
        updateDataAttribute: true
    },
    snapping: {
        type: 'select',
        options: {
            'on': 1,
            'off': 0
        },
        default: 1,
        updateDataAttribute: true,
        callback: function (element, value, slidemeister, target) {
            slidemeister.ui.toggleSnapping(value);
        }
    },
    textAlign: {
        type: 'select',
        options: {
            'left': 'left',
            'center': 'center',
            'right': 'right'
        },
        default: 'left',
        updateCss: ['text-align'],
        updateDataAttribute: true
    },
    horizontalAlign: {
        type: 'select',
        options: {
            'left': 'flex-start',
            'center': 'center',
            'right': 'flex-end'
        },
        default: 'flex-start',
        updateCss: ['justify-content'],
        updateDataAttribute: true
    },
    verticalAlign: {
        type: 'select',
        options: {
            'top': 'flex-start',
            'center': 'center',
            'bottom': 'flex-end'
        },
        default: 'flex-start',
        updateCss: ['align-items'],
        updateDataAttribute: true
    },
    color: {
        type: 'color',
        default: '#000000',
        updateCss: ['color'],
        updateDataAttribute: true
    },
    backgroundColor: {
        type: 'color',
        default: 'transparent',
        updateCss: ['background-color'],
        updateDataAttribute: true
    },
    textShadow: {
        type: 'text',
        default: '',
        updateCss: ['text-shadow'],
        updateDataAttribute: true,
        visible: false,
    },
    text: {
        type: 'textarea',
        default: 'Lorem Ipsum',
        updateDataAttribute: true,
        visible: false,
        callback: function (element, value, slidemeister, target) {
            //console.log("text change");
            slidemeister.ui.updateImages(element);
            slidemeister.ui.resizeText(element);
        }
    },
    locked: {
        type: 'select',
        options: {
            'on': 1,
            'off': 0
        },
        default: 0,
        updateDataAttribute: true,
        callback: function (element, value, slidemeister, target) {
            slidemeister.element.toggleLocking(element, value);
        }
    },
    visibility: {
        type: 'select',
        options: {
            'render': 'render',
            'preview': 'preview'
        },
        default: 'render',
        updateDataAttribute: true
    },
    editable: {
        type: 'select',
        options: {
            'yes': 1,
            'no': 0
        },
        default: 1,
        updateDataAttribute: true
    },
    // lineHeight is making problems with webfonts... :(
    //lineHeight: {
    //    type: 'text',
    //    default: '1.0',
    //    updateCss: ['line-height'],
    //    updateDataAttribute: true
    //},
    opacity: {
        type: 'text',
        default: '1.0',
        updateCss: ['opacity'],
        updateDataAttribute: true
    },
    //padding: {
    //    type: 'text',
    //    default: '0',
    //    updateCss: ['padding'],
    //    updateDataAttribute: true
    //},
    image: {
        type: 'select',
        default: '',
        // options: getAssets('assets'),
        updateDataAttribute: true,
        visible: false,
        callback: function(element, value, slidemeister, target) {
            slidemeister.ui.updateImages(element);
        }
    },
    zIndex: {
        type: 'text',
        default: '',
        updateDataAttribute: true,
        updateCss: ['z-index'],
        visible: false,
        callback: function(element, value, slidemeister, target) {
//            console.log("TODO: change layer order");
        }
    },
    //zoom: {
    //    elementProperty: false,
    //    globalProperty: true,
    //    type: 'select',
    //    options: {
    //        '100%': '1.0',
    //        '75%': '0.75',
    //        '50%': '0.5',
    //        '25%': '0.25'
    //    },
    //    default: '0.5',
    //    callback: function (element, value, slidemeister, target) {
    //        console.log("zoom change");
    //        //$(target).css('zoom', value);
    //    }
    //},
    // bgImage: {
    //     elementProperty: false,
    //     globalProperty: true,
    //     type: 'select',
    //     options: getAssets('backgrounds'),
    //     default: '',
    //     visible: false,
    //     callback: function (element, value, slidemeister, target) {
    //         $(target).css('display', 'block');
    //         $(target).css('background-image', 'url('+value+')');
    //     }
    // },
    rotation: {
        type: 'text',
        default: '0',
        updateCss: ['transform'],
        updateDataAttribute: true,
        visible: false,
    },
};
