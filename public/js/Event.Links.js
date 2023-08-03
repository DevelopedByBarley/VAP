const eventListCon = document.getElementById('event-links-container');
const addEventLinkBtn = document.getElementById('add-event-link-btn');
/**
 *   <div class="form-outline mb-4">
    <div class="mb-3">
      <label for="formFile" class="form-label">Link URL</label>
      <input class="form-control" type="text" id="formFile" name="link" required placeholder="URL">
    </div>
  </div>F
 */
console.log(eventListCon);

let eventState = [
    {
      id: generateUUID()
    }
]

function renderStateEvents() {
  let temp = ``

  eventState.forEach((document, index) => {
    temp += `
    <div class="form-outline mb-4">
      <div class="mb-3">
        <label for="formFile" class="form-label">Link URL</label>
        <input class="form-control" type="text" id="formFile" name="links[]" required placeholder="URL">
      </div>
      ${index !== 0 ? '<button class="btn btn-outline-danger delete-event-link-btn" data-id="'+ document.id +'">Törlés</button>' : ''}
    </div>
    `
  })

  eventListCon.innerHTML = temp;

  const deleteEventLinkBtn = document.querySelectorAll('.delete-event-link-btn');

  deleteEventLinkBtn.forEach(btn =>  {
    btn.addEventListener('click', deleteEventLink)
  })
}


function deleteEventLink(e) {
  e.preventDefault();
  
  let id = e.target.dataset.id;
  let index = eventState.findIndex(event => event.id === id);
  
  eventState.splice(index, 1);
  renderStateEvents();
}

addEventLinkBtn.addEventListener('click', (e) => {
  e.preventDefault();
  eventState.push({
    id: generateUUID()
  })

  renderStateEvents();
})


renderStateEvents();
