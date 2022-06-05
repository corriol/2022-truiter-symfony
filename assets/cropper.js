// import $ from 'jquery';
//import 'bootstrap';
//import 'cropperjs'
//import * as Cropper from 'prestaimage/js/cropper';

let $ = require("jquery");
//require("jquery")
require('bootstrap');
require('cropperjs');
//require('popper.js');


let Cropper = require("../public/bundles/prestaimage/js/cropper");
import "../public/bundles/prestaimage/css/cropper.css";
//require("cropperjs/dist/cropper.min.css");

require("cropperjs/dist/cropper.min.css");
require("bootstrap/dist/css/bootstrap.css");

//import 'cropperjs/dist/cropper.min.css';

$(function () {
    $('.cropper').each(function () {
        new Cropper($(this), true);
    });
});
