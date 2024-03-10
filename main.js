var dates = null;
document.addEventListener("DOMContentLoaded", async () => {
  const response = await fetch("/get.php");
  dates = await response.json();
  loadEntry(dates, getCurrentEntry());
});

function loadEntry(data, index) {
  const veranstaltung = document.getElementById("veranstaltung");
  const datum = document.getElementById("datum");
  const startzeit = document.getElementById("startzeit");
  const endzeit = document.getElementById("endzeit");
  const location = document.getElementById("location");
  const beschreibung = document.getElementById("beschreibung");
  const dtdisplay = document.getElementById("dtdisplay");

  veranstaltung.value = data[index].veranstaltung;
  datum.value = data[index].datum;
  startzeit.value = data[index].startzeit;
  endzeit.value = data[index].endzeit;
  location.value = data[index].information;
  beschreibung.value = data[index].veranstalter;

  date = new Date(data[index].datum);

  veranstaltung.value = data[index].veranstaltung;
  datum.value = data[index].datum;
  startzeit.value = data[index].startzeit;
  endzeit.value = data[index].endzeit;
  location.value = data[index].information;
  beschreibung.value = data[index].veranstalter;

  dtdisplay.innerHTML = formatDate(data[index].datum);
  displayCalendarEvents(data[index].datum);
}

function displayCalendarEvents(date) {
  display = document.getElementById("display");
  display.innerHTML = "Lade...";
  fetch("/getEvents.php?date=" + date)
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

function calendarEntryHTML(title, start, end, location, description, repeat) {
  return `
    <div style="padding: 10px; background: #dedede; margin-bottom: 20px;">
      <h3 class="title" style="margin: 0 0 10px 0;">${title}</h3>
      <div class="time"><strong>Von-Bis:</strong> ${formatDate(start, true)} - ${formatDate(end, true)}</div>
      <div class="location"><strong>Location:</strong> ${location}</div>
      <div class="description"><strong>Beschreibung:</strong> ${description}</div>
      <div class="repeat"><strong>Wiederholend:</strong> ${repeat}</div>
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
    return entry;
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
