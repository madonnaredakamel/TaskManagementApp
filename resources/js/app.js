import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


document.addEventListener('DOMContentLoaded', function() {
    // Fetch total users by role
    fetch('/admin/stats/users')
      .then(response => response.json())
      .then(data => {
        const userStatsTableBody = document.getElementById('user-stats-table-body');
        data.forEach(userStat => {
          const row = document.createElement('tr');
          row.innerHTML = `<td>${userStat.role}</td><td>${userStat.total}</td>`;
          userStatsTableBody.appendChild(row);
        });
      });
  
    // Fetch total tasks by status and priority
    fetch('/admin/stats/tasks')
      .then(response => response.json())
      .then(data => {
        const taskStatsTableBody = document.getElementById('task-stats-table-body');
        data.forEach(taskStat => {
          const row = document.createElement('tr');
          row.innerHTML = `<td>${taskStat.status}</td><td>${taskStat.priority}</td><td>${taskStat.total}</td>`;
          taskStatsTableBody.appendChild(row);
        });
      });
  
    // Fetch average task completion time
    fetch('/admin/stats/avg-completion-time')
      .then(response => response.json())
      .then(data => {
        const avgCompletionTime = document.getElementById('avg-completion-time-value');
        avgCompletionTime.textContent = data.avg_completion_time;
      });
  });
  
