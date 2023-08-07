const eventLinksCon = document.getElementById('event-links-container');
const addEventLinkBtn = document.getElementById('add-event-link-btn');

addEventLinkBtn.addEventListener('click', (e) => {
  e.preventDefault();
  eventLinksState.push({
    id: generateUUID()
  })

  renderLinkEvents();
});

let prevLinks = eventLinksCon.dataset.content;

let eventLinksState = prevLinks !== undefined ? JSON.parse(prevLinks) : [
  {
    id: generateUUID()
  }
]

console.log(eventLinksState);


function renderLinkEvents() {
  let temp = ``

  eventLinksState.forEach((document, index) => {
    temp += `
    <div class="form-outline mb-4">
      <div class="mb-3">
        <label for="formFile" class="form-label">Link URL</label>
        <input class="form-control" type="text" id="formFile" name="links[]" required placeholder="URL" value="${document.link !== undefined ? document.link : ''}">
      </div>
      ${index !== 0 ? '<button class="btn btn-outline-danger delete-event-link-btn" data-id="' + document.id + '">Törlés</button>' : ''}
    </div>
    `
  })

  eventLinksCon.innerHTML = temp;

  const deleteEventLinkBtn = document.querySelectorAll('.delete-event-link-btn');

  deleteEventLinkBtn.forEach(btn => {
    btn.addEventListener('click', deleteEventLink)
  })
}


function deleteEventLink(e) {
  e.preventDefault();

  let id = e.target.dataset.id;
  let index = eventLinksState.findIndex(event => event.id === id);

  eventLinksState.splice(index, 1);
  renderLinkEvents();
}



renderLinkEvents();
