var dates = null;
document.addEventListener("DOMContentLoaded", async () => {
  const response = await fetch("/admin/get.php");
  dates = await response.json();
  loadEntry(dates, getCurrentEntry());
  document.getElementById("countMax").innerHTML = dates.length;
});

function jumpToDateAlert() {
  var date = prompt("Datum (yyyy-mm-dd):");
  if (
    !dates.find((entry, index) => {
      if (entry.datum == date) {
        setEntryInUrl(index);
        loadEntry(dates, index);
        return true;
      } else {
        return false;
      }
    })
  ) {
    alert("Es existiert kein Eintrag mit diesem Datum!");
  }
}
function goToEntryAlert() {
  var entry = parseInt(prompt("Eintrag Nr.:")) - 1;
  if (entry < 0 || entry >= dates.length) {
    alert("Eintrag existiert nicht!");
    return;
  }
  setEntryInUrl(entry);
  loadEntry(dates, entry);
}

function newEvent() {
  dates.push({
    veranstaltung: "",
    datum: "",
    startzeit: "",
    endzeit: "",
    information: "",
    veranstalter: "",
  });
  setEntryInUrl(dates.length - 1);
  loadEntry(dates, dates.length - 1);
  document.getElementById("countMax").innerHTML = dates.length;
}

function validateAllInputs() {
  document
    .getElementById("form")
    .querySelectorAll(".validateAll")
    .forEach((input) => {
      validateMe(input);
    });
}
function validateMe(obj) {
  if (obj.value.length == 0) {
    obj.classList.add("invalid");
  } else {
    obj.classList.remove("invalid");
  }
}

function sendToCalendar() {
  const veranstaltung = document.getElementById("veranstaltung");
  const datum = document.getElementById("datum");
  const startzeit = document.getElementById("startzeit");
  const endzeit = document.getElementById("endzeit");
  const location = document.getElementById("location");
  const beschreibung = document.getElementById("beschreibung");
  const ganztag = document.getElementById("ganztag");

  const eventData = {
    titel: veranstaltung.value,
    date: datum.value,
    start: startzeit.value,
    end: endzeit.value,
    location: location.value,
    beschreibung: beschreibung.value,
    ganztag: ganztag.checked,
  };

  fetch("/admin/newEvent.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(eventData),
  })
    .then((response) => response.json())

    .then((data) => {
      if (data.error) {
        alert("Das hat nicht geklappt! Bitte Konsole überprüfen.");
        console.error(data.error);
      }
      displayCalendarEvents(datum.value);
    });
}

function dateChanged() {
  displayCalendarEvents(document.getElementById("datum").value);
}

function loadEntry(data, index) {
  const veranstaltung = document.getElementById("veranstaltung");
  const datum = document.getElementById("datum");
  const startzeit = document.getElementById("startzeit");
  const endzeit = document.getElementById("endzeit");
  const location = document.getElementById("location");
  const beschreibung = document.getElementById("beschreibung");
  const countDisplay = document.getElementById("countNow");

  countDisplay.innerHTML = index + 1;
  date = new Date(data[index].datum);

  veranstaltung.value = data[index].veranstaltung;
  datum.value = data[index].datum;
  startzeit.value = data[index].startzeit;
  endzeit.value = data[index].endzeit;
  location.value = data[index].information;
  beschreibung.value = "Veranstalter: " + data[index].veranstalter;

  displayCalendarEvents(data[index].datum);
  validateAllInputs();
}

function displayCalendarEvents(date) {
  const dtdisplay = document.getElementById("dtdisplay");
  dtdisplay.innerHTML = formatDate(date);
  const display = document.getElementById("display");
  display.innerHTML = getLoader();
  fetch("/admin/getEvents.php?date=" + date)
    .then((response) => response.json())
    .then((data) => {
      display.innerHTML = "";
      if (data.length == 0) display.innerHTML = "Keine Einträge";
      data.forEach((event) => {
        const div = document.createElement("div");
        div.innerHTML = calendarEntryHTML(
          event.titel,
          event.start,
          event.end,
          event.location,
          event.description,
          event.repeat
        );
        display.appendChild(div);
      });
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

function getLoader() {
  return (
    '<p class="inline-flex  items-center px-4 py-2 font-semibold leading-6 text-sm  rounded-md bg-white"><svg class="-ml-1 mr-3 h-5 w-5 animate-spin text-indigo-500" xmlns="http://www.w3.org/2000/svg"' +
    'fill="none" viewBox="0 0 24 24">' +
    '<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>' +
    '<path class="opacity-75" fill="currentColor"' +
    'd="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">' +
    "</path> </svg> Lade...</p>"
  );
}

function calendarEntryHTML(title, start, end, location, description, repeat) {
  return `
<div class="bg-white rounded px-4 py-2 mb-4">
    <h3 class="text-lg font-semibold mb-2">${title}</h3>
    <div class="time"><span class="border-b border-dotted border-current">Von-Bis:</span> ${formatDate(
      start,
      true
    )} - ${formatDate(end, true)}</div>
    <div class="location"><span class="border-b border-dotted border-current">Location:</span> ${location}</div>
    <div class="description"><span class="border-b border-dotted border-current">Beschreibung:</span> ${description}</div>
</div>`;
}

function nextEntry() {
  var newEntry = parseInt(getCurrentEntry()) + 1;
  if (newEntry > dates.length) return;
  setEntryInUrl(newEntry);
  loadEntry(dates, newEntry);
}
function prevEntry() {
  var newEntry = parseInt(getCurrentEntry()) - 1;
  if (newEntry < 0) return;
  setEntryInUrl(newEntry);
  loadEntry(dates, newEntry);
}
function getCurrentEntry() {
  var url = new URL(window.location.href);
  var entry = url.searchParams.get("entry");
  if (entry == null) {
    url.searchParams.set("entry", 0);
    history.pushState(null, null, "?" + url.searchParams.toString());
    return 0;
  } else {
    return parseInt(entry);
  }
}
function setEntryInUrl(entryNr) {
  var url = new URL(window.location.href);
  url.searchParams.set("entry", entryNr);
  history.replaceState(null, null, "?" + url.searchParams.toString());
}
function formatDate(dateString, time = false) {
  const date = new Date(dateString);
  const day = date.getDate();
  const month = date.getMonth() + 1;
  const year = date.getFullYear();
  const hours = date.getHours();
  const minutes = date.getMinutes();
  if (time) {
    return `${hours < 10 ? "0" + hours : hours}:${minutes < 10 ? "0" + minutes : minutes}`;
  }
  return `${day < 10 ? "0" + day : day}.${month < 10 ? "0" + month : month}.${year}`;
}
function toggleGanztag() {
  document.querySelectorAll(".hideGanztag").forEach((el) => {
    el.style.display = document.getElementById("ganztag").checked ? "none" : "flex";
  });
}
