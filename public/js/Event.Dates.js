const eventDateCon = document.getElementById('event-dates-container');
const addEventDateBtn = document.getElementById('add-event-date-btn');

let prevContent = eventDateCon.dataset.content;


let eventDateState = prevContent !== undefined ? JSON.parse(prevContent) : [
  {
    id: generateUUID(),
    date: ""
  }
]

let startDate = document.getElementById('start-date');
let endDate = document.getElementById('end-date');
let regEndDate = document.getElementById('reg-end-date');



let dateOfEvent = {
  startDate: startDate.value !== '' ? startDate.value : '',
  endDate: endDate.value !== '' ? endDate.value : '',
  regEndDate: regEndDate.value !== '' ? regEndDate.value : '',
}

regEndDate.addEventListener('change', (event) => {
  dateOfEvent.regEndDate = event.target.value;

  if(dateOfEvent.startDate === '') {
    alert('A regisztráció lezárása előtt válassza ki a kezdő dátumot!');
    regEndDate.value = '';
    dateOfEvent.regEndDate = event.target.value;
    return;
  }

  if (dateOfEvent.regEndDate >= dateOfEvent.startDate) {
    alert('A regisztráció lezárásának dátuma nem lehet nagyobb vagy egyenlő mint a kezdő dátum!');
    regEndDate.value = '';
    dateOfEvent.regEndDate = event.target.value;
    return;
  }

  let reset = eventDateState.slice(0, 1);
  reset[0].date = ''
  eventDateState = reset;

  renderDatesOfEvent();
})



startDate.addEventListener('change', (event) => {
  dateOfEvent.startDate = event.target.value;

  if (endDate.value !== '' && dateOfEvent.startDate > dateOfEvent.endDate) {
    alert('A kezdő dátum nem lehet nagyobb mint a befejezés dátuma!');
    startDate.value = '';
    dateOfEvent.startDate = event.target.value;
    return;
  }


  let reset = eventDateState.slice(0, 1);
  reset[0].date = ''
  eventDateState = reset;

  renderDatesOfEvent();

})


endDate.addEventListener('change', (event) => {
  dateOfEvent.endDate = event.target.value;
  if (dateOfEvent.startDate > dateOfEvent.endDate) {
    alert('A kezdő dátum nem lehet nagyobb mint a befejezés dátuma!');
    endDate.value = '';
    dateOfEvent.endDate = event.target.value;
    console.log(dateOfEvent);
    return;
  }

  let reset = eventDateState.slice(0, 1);
  reset[0].date = ''
  eventDateState = reset;
  renderDatesOfEvent();


})





function renderDatesOfEvent() {


  let temp = ``

  eventDateState.forEach((document, index) => {

    temp += `
    <div class="form-outline mb-4">
    <input type="date" name="event_dates[]" class="mt-1 w-100 event-date" required data-index="${index}" value="${document.date !== '' ? document.date : ''}" min="${dateOfEvent.startDate}" max="${dateOfEvent.endDate}" ${dateOfEvent.endDate === '' || dateOfEvent.startDate === '' ? 'disabled' : ''}/>
      ${index !== 0 ? '<button class="btn btn-outline-danger delete-event-date-btn btn-sm mb-1 mt-3" data-id="' + document.id + '">Törlés</button>' : ''}
    </div>
    `
  })

  eventDateCon.innerHTML = temp;

  const deleteEventDateBtn = document.querySelectorAll('.delete-event-date-btn');
  const dateInputs = document.querySelectorAll('.event-date');

  if (dateOfEvent.startDate !== '' && dateOfEvent.endDate !== '') {
    dateOfStart = new Date(dateOfEvent.startDate)
    dateOfEnd = new Date(dateOfEvent.endDate);

    const oneDay = 24 * 60 * 60 * 1000; // Egy nap milliszekundumban

    const diffDays = Math.round(Math.abs((dateOfEnd - dateOfStart) / oneDay)) + 1;

    if (dateInputs.length === diffDays) {
      addEventDateBtn.style.display = "none";
    } else {
      addEventDateBtn.style.display = "block";
    }
  }



  dateInputs.forEach((date) => {
    date.addEventListener('change', (event) => {

      let index = event.target.dataset.index;
      let date = event.target.value;
      eventDateState[index].date = event.target.value;

      var valueArr = eventDateState.map(function (item) { return item.date });

      let prev = valueArr[index];
      valueArr[index] = date;

      var isDuplicate = valueArr.some(function (item, idx) {
        if (item !== '') {
          return valueArr.indexOf(item) != idx
        }
      });

      if (isDuplicate) {
        alert('Figyelem, kétszer ugyan az a dátum nem szerepelhet a dátumok listájában!');
        event.target.value = '';
        console.log(prev);
        valueArr[index] = prev ? prev : '';
        return;

      }
    })
  })

  deleteEventDateBtn.forEach(btn => {
    btn.addEventListener('click', deleteEventDate)
  })
}





function deleteEventDate(e) {
  e.preventDefault();

  let id = e.target.dataset.id;
  let index = eventDateState.findIndex(event => event.id === id);

  eventDateState.splice(index, 1);
  renderDatesOfEvent();
}

addEventDateBtn.addEventListener('click', (e) => {
  e.preventDefault();
  eventDateState.push({
    id: generateUUID(),
    date: ""
  })

  renderDatesOfEvent();
})


renderDatesOfEvent();
