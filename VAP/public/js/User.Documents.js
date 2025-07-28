let lang = getCookie("lang");
const documentContainer = document.getElementById("documents-container");
const addDocumentBtn = document.getElementById("add-document");
let state = [
  {
    id: generateUUID()
  }
];


const translations = {
  typeOfDocument: {
    title: {
      En: "Type of document",
      Hu: "Dokumentum típusa"
    },
    letter: {
      En: "Cover letter",
      Hu: "Motivációs levél"
    },
    cv: {
      En: "CV",
      Hu: "Önéletrajz"
    },
    other: {
      En: "Other",
      Hu: "Egyéb"
    }

  }
};


addDocumentBtn.addEventListener('click', (e) => {
  e.preventDefault();
  if (state.length < 3) {
    state.push({
      id: generateUUID()
    })
  }
  render();
})

function render() {
  let temp = ``

  state.forEach((document, index) => {
    console.log(index);
    temp += `
    <div class="document border p-3 mt-2">
      <select class="form-select mb-3" aria-label="Default select example" required name=typeOfDocument[]>
        <option selected disabled value="">${translations.typeOfDocument.title[lang]}</option>
        <option value="1">${translations.typeOfDocument.letter[lang]}</option>
        <option value="2">${translations.typeOfDocument.cv[lang]}</option>
        <option value="3">${translations.typeOfDocument.other[lang]}</option>
      </select>
      <div class="mb-3" class="document">
        <input class="form-control" type="file" name="documents[]" id="documents" required />
        ${index !== 0 ? '<button class="btn btn-outline-danger delete-document mt-3" data-id="' + document.id + '">Törlés</button>' : ''}    
      </div>
    </div>`
  })

  if(state.length === 2) {
    addDocumentBtn.style.display = "none";
  } else {
    addDocumentBtn.style.display = "block";
  }

  documentContainer.innerHTML = temp;


  let deleteBtn = document.querySelectorAll('.delete-document');
  deleteBtn.forEach((btn) => {
    btn.addEventListener('click', deleteDocument);
  })
}

function deleteDocument(e) {
  e.preventDefault();

  let id = e.target.dataset.id;
  let index = state.findIndex(doc => doc.id === id);

  state.splice(index, 1)
  render();
}


render();



function generateUUID() {
  let dt = new Date().getTime();
  const uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
    const r = (dt + Math.random() * 16) % 16 | 0;
    dt = Math.floor(dt / 16);
    return (c === 'x' ? r : (r & 0x3 | 0x8)).toString(16);
  });
  return uuid;
}

function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return parts.pop().split(';').shift();
}