// import 'node_modules/ol/ol.css';
// import { Map, View } from 'node_modules/ol';
// import ImageLayer from 'node_modules/ol/layer/Image';
// import ImageSource from './ImageCanvas.js';
// import Projection from 'node_modules/ol/proj/Projection';
// import { getCenter } from 'node_modules/ol/extent';
// import { defaults as defaultControls, FullScreen } from 'node_modules/ol/control.js';
// import { defaults as defaultInteractions, DragRotateAndZoom } from 'node_modules/ol/interaction.js';

import './olCustom.css';
// import 'ol/ol.css';


// import { Map, View } from './node_modules/ol';
// import ImageLayer from './node_modules/ol/layer/Image.js';
// import ImageSource from './ImageCanvas.js';
// import Projection from './node_modules/ol/proj/Projection.js';
// import { defaults as defaultControls, FullScreen, Control } from './node_modules/ol/control.js';
// import { defaults as defaultInteractions, DragRotateAndZoom } from './node_modules/ol/interaction.js';
import { Map, View } from 'ol';
import ImageLayer from 'ol/layer/Image';
import ImageSource from './ImageCanvas.js';
import Projection from 'ol/proj/Projection';
import { defaults as defaultControls, FullScreen, Control } from 'ol/control.js';
import { defaults as defaultInteractions, DragRotateAndZoom, DragZoom } from 'ol/interaction.js';
// import Zoom from 'ol/control/Zoom';
// import { getCenter } from 'ol/extent';
// import getKeys from 'ol/interaction/KeyboardPan';
import keyboardPan from 'ol/interaction/KeyboardPan';
import keyboardZoom from 'ol/interaction/KeyboardZoom';
import getProjection  from 'ol/proj/Projection';

// import keyboardZoom from 'ol/interaction/KeyboardZoom';
// import keyboardZoom from 'ol/interaction/KeyboardZoom';
// import { getKeys } from 'ol/Object';

import $ from 'jquery';
// export for others scripts to use
// window.$ = $;
// var url = 'http://localhost/test.pdf', id = 'map';
// // console.log("Before function definition");

// var keyboardPan = new ol.interaction.KeyboardPan({
//   duration: 90,
//   pixelDelta: 256
// });

// var keyboardZoom = new ol.interaction.KeyboardZoom({
//   duration: 90
// });
// function browserZoomReset() {
//   // $("input, textarea").focusout(function () {
//     $('meta[name=viewport]').remove();
//     $('head').append('<meta name="viewport" content="width=device-width, maximum-scale=1.0, user-scalable=0">');

//     $('meta[name=viewport]').remove();
//     $('head').append('<meta name="viewport" content="width=device-width, initial-scale=yes">');
  // });
  // let restore = $('meta[name=viewport]')[0];
  // if (restore) {
  //   restore = restore.outerHTML;
  // }
  // $('meta[name=viewport]').remove();
  // $('head').append('<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">');
  // if (restore) {
  //   setTimeout(() => {
  //     $('meta[name=viewport]').remove();
  //     $('head').append(restore);
  //   }, 50); // On Firefox it needs a delay > 0 to work
  // }
// }
// browserZoomReset()
// var scale = 'scale(1)';
// document.body.style.webkitTransform = scale;    // Chrome, Opera, Safari
// document.body.style.msTransform = scale;       // IE 9
// document.body.style.transform = scale;  

function newPdf(url, id) {
  // // console.log("After function definition")
  // document.onmousedown = disableRightclick;
  // function disableRightclick(evt) {
  //   if (evt.button == 2) {
  //     return false;
  //   }
  // }

  // Must be repeated. Private element of class. or function? Export class? Or just call function with parameters that does not return?
  // Unique variables are url and map.
  // var url = "http://localhost/multiLoginOOP/test.pdf";
  var first = true, map, scaleInit = 2.5;

  // var centerArrayCoordinate;
  // var centerArrayView;

  var canvas = document.createElement("canvas");
  var ctx = canvas.getContext('2d');
  canvas.style.width = "90%";
  canvas.style.height = "90%";
  canvas.style.maxHeight = "950px";
  canvas.style.maxWidth = "800px";
  // canvas.style.width = "" + $(document).width() * 9 / 10 * 800 / 950 + "px";
  // canvas.style.height = "" + $(document).width() * 9 / 10 * 950 / 800 + "px";
  // canvas.style.height = "" + canvas.style.width*950/800 + "px";

  // var extent = [0,0,0,0];
  var extent = [0, 0, $('#' + id).width(), $('#' + id).height()];

  // var extent = [0, 0, canvas.width, canvas.height];
  var projection = new Projection({
    // code: 'xkcd-image',
    code: 'pixel-projection',
    units: 'pixels',
    extent: extent,
  });

  var view = new View({
    projection: projection,
    center: [0, 0],
    // center: getCenter(extent),
    // center: [$('#' + id).width()/2, $('#' + id).height()/2],
    // center: getCenter(extent),
    // zoom: 2,
    // Initially, display canvas at original resolution (100%).
    resolution: 1,
    zoomFactor: 1.5,
    // maxZoom: 8,
    // Allow a maximum of 4x magnification.
    minResolution: 0.25,
    maxResolution: 4,
    // Restrict movement.
    // extent: extent,
  });

  var source = new ImageSource({
    canvas: canvas,
    projection: projection,
    imageExtent: extent,
  });

  var Reset, nextPage, prevPage;
  // $(document).ready(function () {
  var pdfjsLib = window['pdfjs-dist/build/pdf'];
  // var pdfjsLib = window['../../pdf.js/build/generic/build/pdf'];

  // The workerSrc property shall be specified.
  pdfjsLib.GlobalWorkerOptions.workerSrc = '//mozilla.github.io/pdf.js/build/pdf.worker.js';
  // pdfjsLib.GlobalWorkerOptions.workerSrc = '../../pdf.js/build/generic/build/pdf.worker.js';

  var pdfDoc = null,
    pageNum = 1,
    pageRendering = false,
    pageNumPending = null,
    scale = scaleInit;

  function renderPage(num) {
    pageRendering = true;
    // Using promise to fetch the page
    pdfDoc.getPage(num).then(function (page) {
      // console.log('Page loaded');
      var viewport = page.getViewport({
        scale: scale
      });
      canvas.height = viewport.height;
      canvas.width = viewport.width;

      // Render PDF page into canvas context
      var renderContext = {
        canvasContext: ctx,
        viewport: viewport
      };
      // var renderTask = page.render(renderContext);
      var renderTask = page.render(renderContext);

      // Wait for rendering to finish
      renderTask.promise.then(function () {
        // console.log('Page rendered');
        // $('link[href="../media/loading/loading.css"], style').remove();
        // $('link[href="../media/loading/loading.css"], style').remove();
        // $('link[id="loading"], style').remove();
        // $('#loading, style').remove();

        pageRendering = false;
        if (pageNumPending !== null) {
          // New page rendering is pending
          renderPage(pageNumPending);
          pageNumPending = null;
        }

        if (first) {

          map = new Map({
            controls: defaultControls().extend([
              new FullScreen(),
              new Reset(),
              new nextPage(),
              new prevPage()
              // new pages()
            ]),
            interactions: defaultInteractions().extend([
              // new keyboardPan({
              //   duration: 90,
              //   pixelDelta: 50
              // }),
              // new keyboardZoom({
              //   duration: 90,
              // })
              // new DragZoom()
              // new Zoom()
              // new DragRotateAndZoom()
            ]),
            target: id,
            layers: [
              new ImageLayer({
                source: source,
              }),
            ],
            view: view,
          });

          first = false;
          resetPDF();
          console.log("I should only happen once");

          // var array = $(".loading");
          // for (let index = 0; index < array.length; index++) {
          //   const element = array[index];
          //   if (element != null) {
          //     element.remove();
          //   }
          // }
          // array.forEach(element => {
          // // document.getElementsByClassName('loading').forEach(element => {
          //   if (element != null) {
          //     element.remove();
          //   }
          // });
          if (document.getElementsByClassName('loading')[0] != null) {
            // document.getElementById('Loading').parentNode.remove();
            document.getElementsByClassName('loading')[0].remove();
            // document.getElementsByClassName('loading')[0].parentNode.removeChild();
            // document.getElementById('Loading').removeChild();
          }
          //
          // for (var i = 0; i < document.styleSheets.length; i++) {
          // void (document.styleSheets.item(i).disabled = true);
          // }
          // $('link[href="../media/loading/loading.css"], style').remove();

        } else {
          map.updateSize();
        }
      });
    });

    // Update page counters
    if (!first) { document.getElementById('page_num' + id).textContent = num; }

  }

  /**
   * If another page rendering in progress, waits until the rendering is
   * finised. Otherwise, executes rendering immediately.
   */
  function queueRenderPage(num) {
    if (pageRendering) {
      pageNumPending = num;
    } else {
      renderPage(num);
    }
  }

  /**
   * Displays previous page.
   */
  function onPrevPage() {
    if (pageNum <= 1) {
      return;
    }
    pageNum--;
    queueRenderPage(pageNum);
  }

  /**
   * Displays next page.
   */
  function onNextPage() {
    if (pageNum >= pdfDoc.numPages) {
      return;
    }
    pageNum++;
    queueRenderPage(pageNum);
  };

  /**
   * Asynchronously downloads PDF.
   */

  var pagesCount;
  pdfjsLib.getDocument(url).promise.then(function (pdfDoc_) {
    pdfDoc = pdfDoc_;
    // document.getElementById('page_count').textContent = pdfDoc.numPages;
    pagesCount = pdfDoc.numPages;

    renderPage(pageNum);

  });

  function resetPDF() {
    // console.log("The following event happened: ", event, "Offsetheight measured: ", $('#' + id).offsetHeight / 2, "Cssheight: ", $('#' + id).height() / 2, "Inner window height:", window.innerHeight / 2);
    document.body.style.zoom = 1.0;
    view.setRotation(0);
    view.setZoom(1);
    // view.setResolution(1);
    console.log("Set zoom to 1 ... ?", view.getZoom());
    // map.updateSize();
    // view.fit([0,0,extent[2]*2, extent[3]/10]);
    // view.fit(extent);
    // view.setCenter([canvas.width / 2, canvas.height / 2]);
    // view.centerOn([0, 0], [canvas.width, canvas.height], [canvas.width / 2.5, canvas.height / 2.5]);
    // view.centerOn([0,0], [canvas.width, canvas.height], [canvas.width / 2.5 - $('#' + id).width() / 2.5, canvas.height / 2.5 - $('#' + id).height() / 2.5]);
    // view.centerOn([canvas.width / 2, canvas.height / 2], [canvas.width, canvas.height], [canvas.width / 2, canvas.height / 3.5]);
    // view.centerOn([canvas.width / 2, $('#' + id).height() / 1.5], [canvas.width, $('#' + id).height()], [canvas.width / 2,  $('#' + id).height() / 1.5]);
    console.log("viewport height: ", Math.max(document.documentElement.clientHeight, window.innerHeight || 0), "JQuery height: ", $('#' + id).height(), "Canvas height: ", canvas.height, "olclass canvas height: ", $('.ol-unselectable').height(), "Map Size:", map.getSize(), "window height: ", $(window).height());
    view.centerOn([canvas.width / 2, canvas.height / 2], [canvas.width, canvas.height], [canvas.width / 2, canvas.height / 2 - $('#' + id).height() / 2]);


    // view.centerOn([canvas.width / 2, canvas.height / 2]);
    // view.centerOn([canvas.width / 2, canvas.height / 2], [canvas.width, canvas.height], [canvas.width / 2, 0]);
    // view.centerOn([canvas.width / 2, canvas.height / 2], [canvas.width, canvas.height], [canvas.width / 2, canvas.height / 2 - document.getElementById(id).offsetHeight / 2]);
  }

  $(document).keydown(function (e) {
    console.log("Res ", view.getResolution());
    console.log("ZoomforRes ", view.getZoomForResolution(view.getResolution()));
    console.log("Zoom ", view.getZoom());
    // console.log("Resses ", view.getResolutions());
    if (e.ctrlKey && e.keyCode === 39) onNextPage();
    if (e.ctrlKey && e.keyCode === 37) onPrevPage();
    if (e.ctrlKey && e.keyCode === 38) {
      view.setZoom(view.getZoom() + 0.2);
      // console.log(view.getMaxZoom());
      // console.log(view.getMinZoom());
      // console.log(view.getMinZoom());
    };
    if (e.ctrlKey && e.keyCode === 40) view.setZoom(view.getZoom() - 0.2);
    if (e.keyCode === 82) {
      scale = scaleInit;
      queueRenderPage(pageNum);
      resetPDF();
    };
    if (e.ctrlKey && e.keyCode === 27) toggleDocumentFullScreen();
  });


  Reset = (function (Control) {
    function Reset(opt_options) {
      var options = opt_options || {};

      var button = document.createElement('button');
      button.innerHTML = 'Reset';
      button.className = "singleButtons";

      var pnum = document.createElement("span");
      pnum.innerHTML = '1';
      pnum.id = "page_num" + id;

      var numof = document.createElement("span");
      numof.innerHTML = ' / ';
      numof.id = "numof";

      var pcount = document.createElement("span");
      pcount.innerHTML = pagesCount;
      pcount.id = "page_count" + id;

      var pagesCon = document.createElement('div');
      // pagesCon.className = 'resetChild ol-unselectable ol-control';
      pagesCon.id = 'resetChild';
      pagesCon.appendChild(pnum);
      pagesCon.appendChild(numof);
      pagesCon.appendChild(pcount);

      var element = document.createElement('div');
      element.className = 'reset ol-unselectable ol-control';
      element.id = 'reset';
      element.appendChild(pagesCon);
      element.appendChild(button);

      Control.call(this, {
        element: element,
        target: options.target
      });

      button.addEventListener('click', this.handleReset.bind(this), false);
    }

    if (Control) Reset.__proto__ = Control;
    Reset.prototype = Object.create(Control && Control.prototype);
    Reset.prototype.constructor = Reset;

    Reset.prototype.handleReset = function handleReset() {
      // this.getMap().getView().setRotation(0);
      // view.setZoom(1);
      scale = scaleInit;
      queueRenderPage(pageNum);
      // view.setCenter([canvas.width / 2, canvas.height / 2]);
      // view.centerOn([canvas.width / 2, canvas.height / 2], [canvas.width, canvas.height], [canvas.width / 2, canvas.height / 2 - $('#' + id).height() / 2]);
      resetPDF();

      // console.log(" Map div: ", [$('#' + id).width(), $('#' + id).height()], "\n PDF Canvas: ", [canvas.width, canvas.height], "\n Selected Coordinate Center: ", [canvas.width / 2, canvas.height / 2], "\n Selected View Center: ", [canvas.width / 2, canvas.height / 2 - $('#' + id).height() / 2]);
      // // console.log("Am I happening?");
    };

    return Reset;
  }(Control));

  nextPage = (function (Control) {
    function nextPage(opt_options) {
      var options = opt_options || {};

      var button = document.createElement('button');
      button.innerHTML = 'Next';
      button.className = "singleButtons";

      var element = document.createElement('div');
      element.className = 'next-page ol-unselectable ol-control';
      element.id = 'next';
      element.appendChild(button);

      Control.call(this, {
        element: element,
        target: options.target
      });

      button.addEventListener('click', this.handleNextPage.bind(this), false);
    }

    if (Control) nextPage.__proto__ = Control;
    nextPage.prototype = Object.create(Control && Control.prototype);
    nextPage.prototype.constructor = nextPage;

    nextPage.prototype.handleNextPage = function handleNextPage() {
      // this.getMap().getView().setRotation(0);
      onNextPage();
    };

    return nextPage;
  }(Control));

  prevPage = (function (Control) {
    function prevPage(opt_options) {
      var options = opt_options || {};

      var button = document.createElement('button');
      button.innerHTML = 'Prev';
      button.className = "singleButtons";

      var element = document.createElement('div');
      element.className = 'prev-page ol-unselectable ol-control';
      element.id = 'prev';
      element.appendChild(button);

      Control.call(this, {
        element: element,
        target: options.target
      });

      button.addEventListener('click', this.handlePrevPage.bind(this), false);
    }

    if (Control) prevPage.__proto__ = Control;
    prevPage.prototype = Object.create(Control && Control.prototype);
    prevPage.prototype.constructor = prevPage;

    prevPage.prototype.handlePrevPage = function handlePrevPage() {

      onPrevPage();

    };

    return prevPage;
  }(Control));

  let modal = document.createElement('div');
  modal.id = "modal" + id;
  let modalContent = document.createElement('div');
  // modal.style = "opacity: 0; position: fixed; top: 0; bottom: 0; left: 0; right: 0; pointer-events: none; transform:translateY(-50%); z-index: 1; padding-top: 25%; padding-bottom: 100px; left: 0; top: 0; width: 100 %; height: 100 %; overflow: auto; background-color: rgba(0, 0, 0, 0);";
  modal.style = "display: none; position: fixed; left: 0; right: 0; transform:translateY(-50%); z-index: 1; padding-top: 400px; padding-bottom: 100px; left: 0; top: 0; width: 100 %; height: 100 %; overflow: auto; background-color: rgba(0, 0, 0, 0);";
  modalContent.style = "color: white; background-color: #80CED7; margin: auto; padding: 10px 0 10px 0; border: none; box-shadow: 1px 1px 2px #80CED7, 0 0 7px rgba(207, 241, 245, 0.796), 0 0 5px #3b5356; border-radius: 6px; width: 400px;";
  modalContent.innerHTML = "Shortcuts: Arrow keys to move. CTRL+Arrow keys for next page or zoom. R for reset";
  document.getElementById(id).appendChild(modal);
  document.getElementById("modal" + id).appendChild(modalContent);
  let timer;

  // document.getElementById(id).onfullscreenchange = (function () {
  document.getElementById(id).addEventListener("fullscreenchange", function () {
    //do something
  
    modal.style.display = "none";
    clearTimeout(timer);
    window.setTimeout(function () {
      // scale = scaleInit;
      // queueRenderPage(pageNum);
      // console.log($(window).height());
      resetPDF();
      if (document.fullscreenElement && document.fullscreenElement.id == id) {
        modal.style.display = "block";
        window.onclick = function () {
          $("#modal" + id).fadeOut();
          console.log("Screen clicked");
        };
        timer = window.setTimeout(function () {
          $("#modal" + id).fadeOut();
          console.log("Timer ran out");
        }, 3500);
      }
    }, 50);
  // });
  }, false);

};

// For each url in level in course, create a new div and call newpdf.
// var domain = window.location.hostname;

// let array = ['http://localhost/multiLoginOOP/media/pdfs/test.pdf'];
let array = ['http://localhost/multiLoginOOP/media/pdfs/test.pdf', 'http://localhost/multiLoginOOP/media/pdfs/test.pdf'];

// $(document).ready(function () {
array.forEach((element, index) => {
  let div = document.createElement('div');
  div.className = index;
  div.id = index;
  // div.style = "width: 800px; height: 950px;";

  div.style = "align-self: center; margin: 2% auto";
  // div.style.width = "90%";
  // div.style.height = "" + window.width*950/800;
  div.style.maxWidth = "800px";
  // div.style = "margin: 3% auto";
  div.style.width = "90%";
  div.style.height = "" + $(document).width() * 9 / 10 * 950 / 800 + "px";
  div.style.maxWidth = "800px";
  div.style.maxHeight = "950px";
  // div.style.height = "" + div.style.width * 950 / 800 + "px";
  // div.style.width = "800px";
  // div.style.height = "950px";
  document.getElementsByClassName("home-wrapper")[0].appendChild(div);
  let hr = document.createElement('hr');
  // hr.style.width = '800px';
  // if (index < (array.length - 1)) {
  document.getElementsByClassName("home-wrapper")[0].appendChild(hr);
  // }

  // document.getElementsByTagName("BODY")[0].appendChild(div);
  // console.log(div);
  newPdf(element, div.id);
});
let div = document.createElement('div');
div.className = 'footer pull-down';
// div.style = "color: rgb(63, 152, 162)";
// div.style = "weight: bold";
let dt = new Date();
let y = dt.getYear() + 1900;
div.innerHTML = "Copyright © " + y + " ykitest.website All Rights Reserved.";

// let p = "<p>Copyright © 2019 https://www.ykitest.website/ All Rights Reserved.</p>";
// let footer = "<div class='footer pull-down'> Copyright ©<? php $the_year = date('Y');echo $the_year; ?><? php echo 'https://www.ykitest.website/' ?>All Rights Reserved.</div>";
// document.getElementsByClassName("home-wrapper")[0].appendChild(footer);
document.getElementsByClassName("home-wrapper")[0].appendChild(div);


// document.onmousedown = disableRightclick;
// function disableRightclick(evt) {
//   if (evt.button == 2) {
//     return false;
//   }
// }
// });