localStorage.removeItem('langs');

const langCon = document.getElementById('language-container');
const modalCon = document.getElementById('language-modal-container');
const langSelectBtn = document.getElementById('language-select-btn');
const langModalBtn = document.getElementById('lang-modal-btn')
const userLanguages = document.getElementById('user-languages');
let prevUserLangData;




if (userLanguages) {
  prevUserLangData = JSON.parse(userLanguages.dataset.langs);
  console.log(prevUserLangData);
}

if (prevUserLangData && prevUserLangData.length !== 0) {
  localStorage.setItem('langs', JSON.stringify(prevUserLangData));
}

let langState = localStorage.getItem('langs') !== null ? JSON.parse(localStorage.getItem("langs")) : [
  {
    id: generateUUID(),
    lang: '0',
    level: ''
  }
];


let basicLangsOfUserLanguages = {
  selectLevel: {
    Hu: "Válaszd ki a nyelvtudás szintjét!",
    En: "Choose your language level!",
    Sp: ""
  },
}


let langs = [
  {
    Hu: "Magyar",
    En: "Hungarian",
    Sp: ""
  },
  {
    Hu: "Angol",
    En: "English",
    Sp: ""
  },
  {
    Hu: "Német",
    En: "Germany",
    Sp: ""
  },
  {
    Hu: "Szerb",
    En: "Serbian",
    Sp: ""
  },
  {
    Hu: "Spanyol",
    En: "Spain",
    Sp: ""
  },
  {
    Hu: "Japán",
    En: "Japan",
    Sp: ""
  }
];




let levels = [
  {
    Hu: "Nem beszélem",
    En: "I don't speak",
    Sp: ""
  },
  {
    Hu: "Anyanyelvi szint",
    En: "Native level",
    Sp: ""
  },
  {
    Hu: "Alapfok",
    En: "Basic level",
    Sp: ""
  },
  {
    Hu: "Középfok",
    En: "Intermediate level",
    Sp: ""
  },
  {
    Hu: "Felsőfok",
    En: "Higher level",
    Sp: ""
  },
]

langModalBtn.addEventListener('click', () => {
  var myModal = new bootstrap.Modal(document.getElementById("lang-modal"), {});
  myModal.show();
})

function renderLangLevels(selectedIndex) {
  let temp = ``;

  levels.forEach((level, index) => {
    console.log(level);
    temp += `
      <option value="${index}" ${index.toString() === selectedIndex ? "selected" : ""}>${level[getCookie("lang")]}</option>
    `;
  });

  return temp;
}


function renderLangs() {
  let temp = ``;


  langState.forEach((lang, index) => {
    console.log(langs[lang.lang])
    temp += `
    <div class="row border p-3 d-flex align-items-center justify-content-center" data-id="${lang.id}">
    <div class="col-sm-2 mt-2">
      <input type="text" class="form-control" disabled placeholder="${langs[lang.lang][getCookie("lang")]}"/>
      <input type="hidden" class="form-control" value="${lang.lang}" name="langs[]"/>
    </div>
    <div class="col-sm-4 mt-2">
      <select class="form-select lang-levels" aria-label="Default select example" required name="levels[]">
        <option value="">${basicLangsOfUserLanguages.selectLevel[getCookie("lang")]}</option>
        ${renderLangLevels(lang.level)}
      </select>
    </div>
    <div class="col-sm-2 mt-2">
      ${index !== 0 ? `<button class="btn btn-outline-danger delete-lang-btn" data-id="${lang.id}">Delete</button>` : ``}
    </div>
  </div>
        `
  });

  langCon.innerHTML = temp;


  const langLevels = document.querySelectorAll('.lang-levels');
  const deleteBtn = document.querySelectorAll('.delete-lang-btn')


  if (deleteBtn) {
    deleteBtn.forEach((btn) => {
      btn.addEventListener('click', deleteLang)
    })
  }

  if (langLevels) {
    langLevels.forEach((level) => {
      level.addEventListener('change', selectLangLevel);
    })
  }

}

function deleteLang(e) {
  e.preventDefault();
  let id = e.target.parentElement.parentElement.dataset.id;

  let index = langState.findIndex(lang => lang.id === id);
  langState.splice(index, 1);

  localStorage.setItem("langs", JSON.stringify(langState))
  renderLangs();
}


function selectLangLevel(e) {
  let id = e.target.parentElement.parentElement.dataset.id;
  let value = e.target.value;

  let index = langState.findIndex(lang => lang.id === id);
  langState[index].level = value;

  localStorage.setItem("langs", JSON.stringify(langState))
}

langSelectBtn.addEventListener('click', (e) => {
  let langRadios = document.getElementsByName('lang');
  let newLang;
  for (i = 0; i < langRadios.length; i++) {
    if (langRadios[i].checked) {
      newLang = {
        id: generateUUID(),
        lang: langRadios[i].value,
        level: ''
      }
    }
  }

  if (newLang === undefined) {
    alert('Kérlek válassz ki egy nyelvet!');
    return;
  }

  langState.push(newLang);
  localStorage.setItem('langs', JSON.stringify(langState));




  var myModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('lang-modal'));
  myModal.hide();
  renderLangs();

})
renderLangs();

function generateUUID() {
  let dt = new Date().getTime();
  const uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
    const r = (dt + Math.random() * 16) % 16 | 0;
    dt = Math.floor(dt / 16);
    return (c === 'x' ? r : (r & 0x3 | 0x8)).toString(16);
  });
  return uuid;
}