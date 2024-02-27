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

  veranstaltung.value = data[index].veranstaltung;
  datum.value = data[index].datum;
  startzeit.value = data[index].startzeit;
  endzeit.value = data[index].endzeit;
  location.value = data[index].information;
  beschreibung.value = data[index].veranstalter;
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
