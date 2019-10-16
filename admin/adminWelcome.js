import datepicker from './datepicker/datepicker.js'
// import datepicker from 'js-datepicker'
import './datepicker/datepicker.scss';
// require('webpack-jquery-ui');
// require('webpack-jquery-ui/css');
import $ from 'jquery';
import tippy from 'tippy.js';
import 'tippy.js/dist/tippy.css';
import 'tippy.js/animations/scale-extreme.css';
import MicroModal from 'micromodal';
import './modal.scss';

Date.prototype.yyyymmdd = function () {
  let mm = this.getMonth() + 1; // getMonth() is zero-based
  let dd = this.getDate();

  return [this.getFullYear(),
  (mm > 9 ? '' : '0') + mm,
  (dd > 9 ? '' : '0') + dd
  ].join('-');
};

// let first = true;
let renderTimeTable;
let BookedUnbookedData = function () {
  let bookedResponseText = "", unbookedResponseText = "";
  renderTimeTable = function (instance) {
    // Show which date was selected.
    // console.log(instance.dateSelected, dateee)
    // console.log(dateee.toISOString())
    // console.log(instance.dateSelected.yyyymmdd())
    let selectedDate = instance.dateSelected.yyyymmdd();

    if (document.getElementById('boxH')) {
      document.getElementById('boxH').remove();
    }

    let ul = document.createElement('ul');
    let ulBooked = document.createElement('ul');
    let ulUnbooked = document.createElement('ul');
    [ulBooked, ulUnbooked].forEach((ele) => {
      ele.style = 'padding: 0';
    });
    // let booked;
    if (document.getElementById(selectedDate).classList.contains('booked')) {
      for (let index = 0; index < bookedResponseText.length; index++) {
        if (selectedDate === bookedResponseText[index].slice(1, 11)) {
          let li = document.createElement('li');
          li.id = bookedResponseText[index].slice(12, 17);
          li.style = "width: max-content; margin: 0 0 0 auto";
          li.classList.add("selectedBooked");
          li.insertAdjacentHTML('beforeend', "<p style='color: black; font-weight: 500; display: inline'> " + bookedResponseText[index].slice(12, 17) + " </p>");
          li.insertAdjacentHTML('beforeend', "<a data-tippy-content='Click to send an email to " + bookedResponseText[index].split('|')[2] + "' class='emailLinks' href='mailto:" + bookedResponseText[index].split('|')[2] + "' style='background-color: white; color: #0645AD; font-weight: 400; display: inline;'> " + bookedResponseText[index].split('|')[1] + " </a>");

          li.insertAdjacentHTML('beforeend', "<a style='color: red; font-weight: 600; cursor: pointer;' class='delBtn btn btn-sm btn-info btn-secondary'>X</a>");
          // li.insertAdjacentHTML('beforeend', "<a style='color: red; font-weight: 600; cursor: pointer;' class='delBtn btn btn-sm btn-info btn-secondary'>X</a>");

          ulBooked.appendChild(li);
        }
      }
      ulBooked.insertAdjacentHTML('afterbegin', "<h2 class='schedulerTitle' style='width:100px'>Booked:</h2>");
    }

    if (document.getElementById(selectedDate).classList.contains('unbooked')) {
      // booked = false;
      for (let index = 0; index < unbookedResponseText.length; index++) {
        if (selectedDate === unbookedResponseText[index].slice(1, 11)) {
          let li = document.createElement('li');
          li.style = "width: max-content; margin: 0 0 0 auto";
          li.innerHTML = unbookedResponseText[index].slice(12, 17) + "  ";
          li.id = unbookedResponseText[index].slice(12, 17);
          li.insertAdjacentHTML('beforeend', "<a style='color: red; font-weight: 600; cursor: pointer;' class='delBtn btn btn-sm btn-info btn-secondary'>X</a>");
          ulUnbooked.appendChild(li);
        }
      }
      ulUnbooked.insertAdjacentHTML('afterbegin', "<h2 class='schedulerTitle' style='width:100px'>Unbooked:</h2>");
    }

    ul.appendChild(ulBooked);
    ul.appendChild(ulUnbooked);
    ul.insertAdjacentHTML('beforeend', '<span style="display: flex; width: max-content; align-items: center; justify-content: center; margin: auto;"> <input id="timeInsert" style="width: 45px; margin: 5px 0 5px 5px; border: 1px solid rgb(23, 162, 184); border-radius: 4px;" placeholder="19:20"></input> <a style="font-weight: 400; cursor: pointer; color: white; margin: 5px;" class="btn btn-sm btn-info btn-secondary" id="Add">+ Add</a> </span>');

    let boxH = document.createElement('div');
    let boxV = document.createElement('div');
    boxH.className = "boxH";
    boxV.className = "boxV";
    boxH.id = "boxH";
    ul.style = "background-color: white; transform: z-index: 2; border: 1px solid #17a2b8; border-radius: 4px; width: max-content; padding: 1%; margin: 0;";
    // ul.style = "position: fixed; background-color: white; transform: z-index: 1; right: 10%; bottom: 10%; translate(-10%, -10%); border: 1px solid #17a2b8; border-radius: 4px; width: fit-content; padding: 1%";
    ul.id = "ul";
    boxV.appendChild(ul);
    boxH.appendChild(boxV);
    document.getElementById('appendDatepicker').appendChild(boxH);
    $("#ul").fadeOut(0, function () { });
    $("#ul").fadeIn(200, function () { });
    // document.getElementById('appendDatepicker').appendChild(ul);

    let time = document.getElementById('timeInsert'); //Get all elements with class "time"
    time.focus();
    time.addEventListener('keyup', function (e) {
      if (e.keyCode === 13) {
        e.preventDefault();
        document.getElementById("Add").click();
      }
    });

    ['keyup', 'keydown'].forEach(evt =>
      time.addEventListener(evt, function (e) {
        let reg = /[0-9]/;
        if (e.key !== 'Backspace') {
          if (this.value.length == 2 && reg.test(this.value)) this.value = this.value + ":"; //Add colon if string length > 2 and string is a number 
          if (this.value.length > 5) this.value = this.value.substr(0, this.value.length - 1);
          if (e.key === ':') this.value = this.value.substr(0, this.value.length - 1);
        }
      })
    )


    let updateUnbookedFrontendTable = new XMLHttpRequest(); // New request object
    updateUnbookedFrontendTable.onload = function () {
      // console.log(this.responseText);
      unbookedResponseText = this.responseText.split("!");
      unbookedResponseText.pop();
      console.log(unbookedResponseText);
      renderTimeTable(instance);
    };

    let insertUnbookedDates = new XMLHttpRequest(); // New request object
    insertUnbookedDates.onload = function () {
      if (this.responseText === "Success") {
        // if (!document.getElementById(selectedDate).classList.contains('qs-disabled')) {
        document.getElementById(selectedDate).classList.add("unbooked");
        // }
        // console.log(this.responseText);
        updateUnbookedFrontendTable.open("get", "selectFromDatabase.php?free=true", true);
        updateUnbookedFrontendTable.send();
      } else {
        alert("Error:  " + this.responseText);
      }
    };

    document.getElementById('Add').onclick = function () {
      if (time.value.length > 4) {
        if (time.value.match(/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/)) {
          let PageToSendTo = "insertUnbookedDates.php?";
          let MyVariable = selectedDate + " " + time.value + ":00";
          let VariablePlaceholder = "date=";
          let UrlToSend = PageToSendTo + VariablePlaceholder + MyVariable;

          insertUnbookedDates.open("get", UrlToSend, true);
          insertUnbookedDates.send();
        } else {
          alert("Time input must be of 24-hour format HH:MM")
        }
      } else {
        alert("Please fill out the time input")
      }
    }

    let updateEntireFrontendTable = new XMLHttpRequest();
    updateEntireFrontendTable.onload = function () {
      console.log(this.responseText);
      let array = this.responseText.split("!");
      array.pop();

      array = array.map((ele) => {
        return JSON.parse(ele);
      })
      console.log(array, array[0], array[0].free);
      unbookedResponseText = array.filter((ele) => {
        return ele.free === "1";
      })
        .map((ele) => {
          return '"' + ele.date + '"';
        });

      bookedResponseText = array.filter((ele) => {
        return ele.free === "0";
      })
        .map((ele) => {
          return '"' + (ele.date) + '"' +  '|' + (ele.name) + '|' + (ele.email);
        });

      console.log(unbookedResponseText);
      console.log(bookedResponseText);

      renderTimeTable(instance);
    }
    let deleteDate = new XMLHttpRequest();
    deleteDate.onload = function () {
      console.log(this.responseText);
      updateEntireFrontendTable.open("get", "selectAllMatchingRows.php", true);
      // updateEntireFrontendTable.open("get", "selectAllMatchingRows.php?date=" + selectedDate, true);
      updateEntireFrontendTable.send();
      // console.log(eleToDelete)
      // document.getElementById(eleToDelete).remove();
    }
    let deleteRecord = function () {
      let PageToSendTo = "deleteDate.php?";
      let liBooked = this.parentNode;
      let MyVariable = selectedDate + " " + liBooked.id + ":00";
      let VariablePlaceholder = "date=";
      let UrlToSend = PageToSendTo + VariablePlaceholder + MyVariable;

      if (liBooked.classList.contains('selectedBooked')) {
        MicroModal.show('modal-1');
        $('.modalYes').click(() => {
          deleteDate.open("get", UrlToSend, true);
          deleteDate.send();
          MicroModal.close('modal-1');
        })
      } else {
        deleteDate.open("get", UrlToSend, true);
        deleteDate.send();
      }
    }

    let delBtns = document.getElementsByClassName("delBtn");
    for (let index = 0; index < delBtns.length; index++) {
      delBtns[index].onclick = deleteRecord;
    }

    // $('#ul').show();
    tippy('.emailLinks', {
      animation: 'scale-extreme',
      inertia: true
    });
  }

  let freeResponse = new XMLHttpRequest(); // New request object
  freeResponse.onload = function () {
    unbookedResponseText = this.responseText.split("!");
    unbookedResponseText.pop();

    for (let index = 0; index < unbookedResponseText.length; index++) {
      if (document.getElementById(unbookedResponseText[index].slice(1, 11))) {
        let aBookedDate = unbookedResponseText[index].slice(1, 11);
        if (!document.getElementById(aBookedDate).classList.contains('qs-disabled')) {
          document.getElementById(aBookedDate).classList.add("unbooked");
        }
      }
    }

  };
  freeResponse.open("get", "selectFromDatabase.php?free=true", false);
  freeResponse.send();

  let bookedResponse = new XMLHttpRequest();
  bookedResponse.onload = function () {
    bookedResponseText = this.responseText.split("!");
    bookedResponseText.pop();
    console.log("Bookedresponestext: ", bookedResponseText, this.responseText);
    for (let index = 0; index < bookedResponseText.length; index++) {
      if (document.getElementById(bookedResponseText[index].slice(1, 11))) {
        let aBookedDate = bookedResponseText[index].slice(1, 11);
        if (!document.getElementById(aBookedDate).classList.contains('qs-disabled')) {
          document.getElementById(aBookedDate).classList.add("booked");
        }
      }
    }
  };

  bookedResponse.open("get", "selectFromDatabase.php?free=false&name=true", false);
  bookedResponse.send();
}
const picker = datepicker('#datepicker', {
  alwaysShow: true,
  showAllDates: true,
  minDate: new Date(),
  onSelect: (instance) => {
    if (instance.dateSelected) {
      renderTimeTable(instance);
    } else {
      // document.getElementById('ul').remove();
      $("#ul").fadeOut(200, function () { $('.boxH').remove(); });
      // $("#ul").hide("fast", function () { $(this).remove(); })
    }
  },
  onMonthChange: (instance) => {
    // first = false;
    BookedUnbookedData();
  },
  // disabler: ((date => date.yyyymmdd() !== dateResponse))
});

BookedUnbookedData();

$(document).ready(() => {
  $(document).click(function (event) {
    // console.log($('.qs-datepicker-container'));
    let target = $(event.target);
    // console.log(target.closest('.qs-datepicker').length, target.closest('#ul').length, "Hidden: ", $('#ul').is(":hidden"))
    if (target.closest('.qs-datepicker').length || target.closest('#ul').length || target.closest('#modal-1').length) {
      // $("#ul").fadeIn(0, function () { });
      // $('#ul').show('fast');
    } else if ($('#ul').is(":visible")) {
      picker.setDate();
      BookedUnbookedData();
      $("#ul").fadeOut(200, function () { $('.boxH').remove(); });
      // $('#ul').hide('fast');
    };
  });
})


// let selectTime = function () {

// };

