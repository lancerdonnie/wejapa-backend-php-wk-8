const urlParams = new URLSearchParams(window.location.search);
const id = urlParams.get('id');

(async () => {
  try {
    const { data } = await axios.get('/api/blogs/readone.php?id=' + id);
    console.log(data);
  } catch (error) {
    console.log(error);
  }
})();
