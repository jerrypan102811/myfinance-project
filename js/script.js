
const form = document.getElementById('form');
const tbody = document.querySelector('#transactions tbody');
const totalSpan = document.getElementById('total');
const chartCanvas = document.getElementById('chart');

let total = 0;
let categoryData = {
  Food: 0,
  Transport: 0,
  Entertainment: 0
};

function updateChart() {
  const ctx = chartCanvas.getContext('2d');
  if (window.myChart) {
    window.myChart.destroy();
  }
  window.myChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: Object.keys(categoryData),
      datasets: [{
        data: Object.values(categoryData),
        backgroundColor: ['#f9a1bc', '#fbc687', '#97e5ef']
      }]
    },
    options: {
      responsive: true
    }
  });
}

form.addEventListener('submit', function(e) {
  e.preventDefault();
  const amount = parseFloat(document.getElementById('amount').value);
  const category = document.getElementById('category').value;
  const date = document.getElementById('date').value;
  const desc = document.getElementById('description').value;

  const row = document.createElement('tr');
  row.innerHTML = `<td>$${amount.toFixed(2)}</td><td>${category}</td><td>${date}</td><td>${desc}</td>`;
  tbody.appendChild(row);

  total += amount;
  totalSpan.textContent = total.toFixed(2);
  categoryData[category] += amount;

  updateChart();
  form.reset();
});

updateChart();
