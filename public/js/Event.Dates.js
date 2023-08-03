const eventDateCon = document.getElementById('event-dates-container');
const addEventDateBtn = document.getElementById('add-event-date-btn');
/**
 *   <div class="form-outline mb-4">
    <div class="mb-3">
      <label for="formFile" class="form-label">Link URL</label>
      <input class="form-control" type="text" id="formFile" name="link" required placeholder="URL">
    </div>
  </div>F
 */
console.log(eventListCon);

let eventDateState = [
    {
      id: generateUUID()
    }
]

function renderDatesOfEvent() {
  let temp = ``

  eventDateState.forEach((document, index) => {
    temp += `
    <div class="form-outline mb-4">
    <input type="date" name="event_dates[]" class="mt-1 w-100" required />
      ${index !== 0 ? '<button class="btn btn-outline-danger delete-event-link-btn btn-sm mb-1 mt-3" data-id="'+ document.id +'">Törlés</button>' : ''}
    </div>
    `
  })

  eventDateCon.innerHTML = temp;

  const deleteEventLinkBtn = document.querySelectorAll('.delete-event-link-btn');

  deleteEventLinkBtn.forEach(btn =>  {
    btn.addEventListener('click', deleteEventLink)
  })
}


function deleteEventLink(e) {
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
