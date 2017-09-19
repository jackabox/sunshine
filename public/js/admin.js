/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(1);
module.exports = __webpack_require__(2);


/***/ }),
/* 1 */
/***/ (function(module, exports) {

$(document).on('change', '#github_repo', function () {
    $.ajax({
        type: 'POST',
        url: '/admin/github/releases',
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        data: {
            'repo': $(this).children('option:checked').val()
        },
        success: function success(response) {
            var items = $.parseJSON(response);
            var select = $('#github_release');
            select.empty();

            if (items.length > 0) {
                $.each(items, function (i, item) {
                    select.append('<option value="' + item.id + '">' + item.name + '</option>');
                });
            } else {
                select.append('<option value="">Repo has no releases</option>');
            }
        }
    });

    $('input[name=github_folder]').attr('placeholder', $(this).val());
});

$(document).on('click', '#fetch_repo_files', function () {
    var button = $(this);
    $.ajax({
        type: 'POST',
        url: '/admin/github/release/download',
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        data: {
            'repo': $('#github_repo option:checked').val(),
            'release': $('#github_release option:checked').val()
        },
        beforeSend: function beforeSend() {
            button.html('Fetching..');
        },
        success: function success(response) {
            var item = $.parseJSON(response);

            console.log(response);

            $('#file_name').val(item.file_name);
            $('#file_path').val(item.file_name);
            $('#file_version').val(item.version);

            button.html('Fetched');
        },
        complete: function complete() {
            button.html('Fetch');
        }
    });
});

/***/ }),
/* 2 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })
/******/ ]);