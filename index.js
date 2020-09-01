const blogs = document.querySelector('.blogs');
const add = document.querySelector('.add');
const form = document.querySelector('form');
const close = document.querySelector('.close');

close.addEventListener('click', (e) => {
  form.style.display = 'none';
});
add.addEventListener('click', (e) => {
  form.style.display = 'block';
});
form.addEventListener('submit', async (e) => {
  e.preventDefault();

  const x = {};
  Array.from(e.target.querySelectorAll('input')).forEach((e, i) => {
    if (i === 0) x.title = e.value;
    if (i === 1) x.tag = e.value;
    if (i === 2) x.author = e.value;
    if (i === 3) x.content = e.value;
  });
  const { data } = axios.post('/api/blogs/create.php', x);
  if (data.message === 'Product was created.') {
    //
  }
  console.log(data);
});

const getInitialData = async () => {
  try {
    const { data } = await axios.get('/api/blogs/read.php');
    data
      .map((blog) => {
        const x = document.createElement('a');
        x.setAttribute('class', 'card');
        x.setAttribute('href', `/blog.php?id=${blog.id}`);
        x.innerHTML = `
      <div class='card-image'></div>
      <div class='card-body'>
        <span>${blog.tag}</span>
        <span>${blog.title}</span>
        <span>${blog.body}</span>
        <div class='card-profile'>
          <div class='card-profile-image'></div>
          <div class='card-profile-body'>
            <span>${blog.author}</span>
            <span>${blog.created}</span>
          </div>
        </div>
      </div>
      `;
        return x;
      })
      .forEach((e) => {
        blogs.append(e);
      });
  } catch (error) {
    console.log(error);
  }
};
getInitialData();
