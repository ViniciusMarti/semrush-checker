document.getElementById('start-check').addEventListener('click', async () => {
    const domainText = document.getElementById('domain-list').value;
    const country = document.getElementById('country').value;
    const domains = domainText.split('\n').map(d => d.trim()).filter(d => d !== '');

    if (domains.length === 0) {
        alert('Por favor, insira pelo menos um domínio.');
        return;
    }

    // UI state
    const btn = document.getElementById('start-check');
    const resultsSection = document.getElementById('results-section');
    const tableBody = document.querySelector('#results-table tbody');
    const progressContainer = document.getElementById('progress-container');
    const progressBar = document.getElementById('progress-bar');
    const progressText = document.getElementById('progress-text');

    btn.disabled = true;
    btn.classList.add('loading');
    resultsSection.classList.remove('hidden');
    progressContainer.classList.remove('hidden');
    tableBody.innerHTML = '';

    let processed = 0;
    const total = domains.length;

    for (const domain of domains) {
        // Add row with "loading" status
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${domain}</td>
            <td class="as-val">-</td>
            <td class="traffic-val">-</td>
            <td class="status-loading">Verificando...</td>
        `;
        tableBody.appendChild(row);

        try {
            const response = await fetch(`api.php?domain=${encodeURIComponent(domain)}&database=${country}`);
            const data = await response.json();

            if (data.error) {
                row.querySelector('.status-loading').className = 'status-error';
                row.querySelector('.status-error').innerText = 'Erro API';
            } else {
                row.querySelector('.as-val').innerText = data.as;
                row.querySelector('.traffic-val').innerText = data.traffic.toLocaleString();
                row.querySelector('.status-loading').className = 'status-done';
                row.querySelector('.status-done').innerText = 'Sucesso';
            }
        } catch (error) {
            row.querySelector('.status-loading').className = 'status-error';
            row.querySelector('.status-error').innerText = 'Erro';
        }

        processed++;
        const percent = Math.round((processed / total) * 100);
        progressBar.style.width = percent + '%';
        progressText.innerText = `Processando: ${processed}/${total}`;
        
        // Auto scroll to bottom of table if it grows
        row.scrollIntoView({ behavior: 'smooth', block: 'end' });
        
        // Pequeno delay para evitar overload (opcional)
        // await new Promise(r => setTimeout(r, 100));
    }

    btn.disabled = false;
    btn.classList.remove('loading');
    progressText.innerText = `Concluído: ${total} domínios processados.`;
});

document.getElementById('clear-results').addEventListener('click', () => {
    document.querySelector('#results-table tbody').innerHTML = '';
    document.getElementById('results-section').classList.add('hidden');
    document.getElementById('progress-container').classList.add('hidden');
    document.getElementById('progress-bar').style.width = '0%';
});

document.getElementById('export-csv').addEventListener('click', () => {
    const rows = Array.from(document.querySelectorAll('#results-table tr'));
    const csvContent = rows.map(row => {
        const cols = Array.from(row.querySelectorAll('th, td'));
        return cols.map(col => `"${col.innerText}"`).join(';');
    }).join('\n');

    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    link.setAttribute('href', url);
    link.setAttribute('download', `semrush_results_${new Date().toISOString().split('T')[0]}.csv`);
    link.style.visibility = 'hidden';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
});
