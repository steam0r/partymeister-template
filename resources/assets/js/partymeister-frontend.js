window._ = require('lodash');

window.$ = window.jQuery = require('jquery');
window.Popper = require('popper.js');
require('bootstrap');

require('mediaelement');
require('@fancyapps/fancybox');
require('./modules/partymeister-rating');
window.toastr = require('toastr');

import fontawesome from '@fortawesome/fontawesome';
import solid from '@fortawesome/fontawesome-free-solid';
import brands from '@fortawesome/fontawesome-free-brands';
import regular from '@fortawesome/fontawesome-free-regular';

fontawesome.library.add(solid, brands, regular);

window.axios = require('axios');
