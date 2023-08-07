const eventDateCon = document.getElementById('event-dates-container');
const addEventDateBtn = document.getElementById('add-event-date-btn');

let prevContent = eventDateCon.dataset.content;



let eventDateState = prevContent !== undefined ? JSON.parse(prevContent) : [
  {
    id: generateUUID()
  }
] 

console.log(eventDateState);


function renderDatesOfEvent() {
  let temp = ``

  eventDateState.forEach((document, index) => {
   
    temp += `
    <div class="form-outline mb-4">
    <input type="date" name="event_dates[]" class="mt-1 w-100" required value="${document.date !== '' ? document.date : ''}"/>
      ${index !== 0 ? '<button class="btn btn-outline-danger delete-event-date-btn btn-sm mb-1 mt-3" data-id="'+ document.id +'">Törlés</button>' : ''}
    </div>
    `
  })

  eventDateCon.innerHTML = temp;

  const deleteEventDateBtn = document.querySelectorAll('.delete-event-date-btn');

  deleteEventDateBtn.forEach(btn =>  {
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
    id: generateUUID()
  })

  renderDatesOfEvent();
})


renderDatesOfEvent();
