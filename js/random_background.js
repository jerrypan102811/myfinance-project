
const colors = [
  "linear-gradient(to right, #ffe4e1, #fff9e6)",
  "linear-gradient(to right, #d0e6ff, #f1fcff)",
  "linear-gradient(to right, #fdf6e3, #ffeebb)",
  "linear-gradient(to right, #e8f0fe, #d7f9f1)",
  "linear-gradient(to right, #fce1ff, #fff0f5)"
];

function setRandomBackground() {
  const randomColor = colors[Math.floor(Math.random() * colors.length)];
  document.body.style.background = randomColor;
}

document.addEventListener("DOMContentLoaded", setRandomBackground);
