const urlParams = new URLSearchParams(window.location.search);
const id = urlParams.get('id');
const blog = document.querySelector('.blogs');
const form = document.querySelector('form');
const add = document.querySelector('.add');
const close = document.querySelector('.close');
let dt;

// contenteditable="true"

document.querySelector('.fa.fa-edit').addEventListener('click', (e) => {
  blog.style.display = 'none';
  Array.from(form.querySelectorAll('.form-input')).forEach((e, i) => {
    console.log(e);
    if (i === 0) e.value = dt.title;
    if (i === 1) e.value = dt.tag;
    if (i === 2) e.value = dt.author;
    if (i === 3) e.value = dt.body;
  });
  form.style.display = 'block';
});

form.addEventListener('submit', async (e) => {
  e.preventDefault();
  const x = { id: dt.id };
  Array.from(e.target.querySelectorAll('.form-input')).forEach((e, i) => {
    if (i === 0) x.title = e.value;
    if (i === 1) x.tag = e.value;
    if (i === 2) x.author = e.value;
    if (i === 3) x.content = e.value;
  });
  const res = axios.post('/api/blogs/update.php', x);
  if ((res.status = '200')) {
    blog.children[1].remove();
    await getData();
    blog.style.display = 'block';
    form.style.display = 'none';
  }
});

const getData = async () => {
  try {
    const { data } = await axios.get('/api/blogs/readone.php?id=' + id);
    console.log(data);
    dt = data;
    const x = document.createElement('div');
    // x.setAttribute('class', 'blogs');
    var y = '';
    y += `<h1>${data.title}</h1>`;
    y += `<span>${data.tag}</span>`;
    y += `<span class="created">${data.created}</span>`;
    y += `<span>By ${data.author}</span>`;
    y += `<div>${data.body}</div>`;
    x.innerHTML = y;
    blog.append(x);
    blog.style.display = 'block';
  } catch (error) {
    console.log(error);
  }
};

getData();
