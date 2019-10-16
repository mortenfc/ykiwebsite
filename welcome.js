import datepicker from 'js-datepicker'
import './datepicker.scss';
import $ from 'jquery';
// var fileContent = require("php!./selectAndInsertFreeDates.php");
// import './node_modules/js-datepicker/dist/datepicker.min.css';
// var loaded = false;
var selectedDate;
var oReq = new XMLHttpRequest(); // New request object
oReq.onload = function () {
  // This is where you handle what to do with the response.
  // The actual data is found on this.responseText
  // var dates = [];
  var response = this.responseText.split("!");
  response.pop();
  // for (let index = 0; index < response.length; index++) {
  //   dates.push(response[i].slice(1, 11));
  // }
  // var dateResponse = this.responseText.slice(1, 11);
  // var timeResponse = this.responseText.slice(12, 17);
  // console.log(this.responseText);
  // console.log(dateResponse);
  // console.log(timeResponse);

  Date.prototype.yyyymmdd = function () {
    var mm = this.getMonth() + 1; // getMonth() is zero-based
    var dd = this.getDate();

    return [this.getFullYear(),
    (mm > 9 ? '' : '0') + mm,
    (dd > 9 ? '' : '0') + dd
    ].join('-');
  };

  // console.log((new Date()).yyyymmdd());

  const picker = datepicker('#datepicker', {
    alwaysShow: true,
    // disabledDates: [
    //   new Date(dateResponse[0], dateResponse[1] - 1, dateResponse[2]),
    // ]
    disabler: (function (date) { //Brute force checks each datepicker date for matching input. Could only check 1 date at a time with tracker in its array if checked before.
      for (let index = 0; index < response.length; index++) {
        if (date.yyyymmdd() === response[index].slice(1, 11)) {
          return false;
        }
      }
      return true;
    }),
    onSelect: (instance) => {
      // Show which date was selected.
      // console.log(instance.dateSelected, dateee)
      // console.log(dateee.toISOString())
      console.log(instance.dateSelected.yyyymmdd())
      selectedDate = instance.dateSelected.yyyymmdd();

      if (document.getElementById('ul')) {
        document.getElementById('ul').remove();
      }
      let ul = document.createElement('ul');
      for (let index = 0; index < response.length; index++) {
        if (selectedDate === response[index].slice(1, 11)) {
          let li = document.createElement('li');
          let radio = document.createElement('input');
          radio.setAttribute('type', 'radio');
          radio.setAttribute('class', 'time');
          radio.setAttribute('name', 'time');
          radio.setAttribute('value', response[index].slice(12, 17));
          li.innerHTML = response[index].slice(12, 17) + "  ";
          li.appendChild(radio);
          ul.appendChild(li);
        }
      }
      ul.style = "position: absolute; right: 15%; z-index: 1; bottom: 10%; border: 1px solid black; border-radius: 4px; width: fit-content; padding: 1%; margin: 1% auto";
      ul.id = "ul";
      document.getElementById('appendDatepicker').appendChild(ul);
      // loaded = true;

    },
    // disabler: ((date => date.yyyymmdd() !== dateResponse))
  });

};
oReq.open("get", "selectFromDatabase.php", true);
//                               ^ Don't block the rest of the execution.
//                                 Don't wait until the request finishes to
//                                 continue.
oReq.send();


var insert = function () {
  if ($('input[name="time"]:checked').length > 0) {
    var insertDates = new XMLHttpRequest(); // New request object
    insertDates.onload = function () {
      console.log(this.responseText)
    }
    var PageToSendTo = "insertBookedDates.php?";
    var MyVariable = selectedDate + " " + document.querySelector('.time:checked').value + ":00";
    console.log("DateTime:", MyVariable);
    var VariablePlaceholder = "date=";
    var UrlToSend = PageToSendTo + VariablePlaceholder + MyVariable;
    insertDates.open("get", UrlToSend, true);
    //                               ^ Don't block the rest of the execution.
    //                                 Don't wait until the request finishes to
    //                                 continue.
    insertDates.send();
  }
}
$(document).ready(function () {
  document.getElementById("book").addEventListener("click", insert);
});
// document.getElementById("book").onclick = insert;

// let selectTime = function () {

// };

