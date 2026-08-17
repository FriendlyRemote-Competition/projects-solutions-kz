const LABELS = {
    pro: 'Pro',
    con: 'Con',
    abs: 'Abs'
}

const showResults = (data) => {
    document.getElementById('title').textContent = data.title;
    document.getElementById('topic').textContent = data.topic;

    const counts = {
        pro: 0,
        con: 0,
        abs: 0
    }

    data.votes.forEach(item => counts[item.vote]++);

    const total = data.votes.length;

    let maj = 'pro';

    for(const vote in counts) {
        if (counts[vote] > counts[maj]) {
            maj = vote;
        }
    }

    document.getElementById('results').innerHTML = Object.keys(counts).map(item => {
        return `
            <tr class="${item === maj ? 'maj' : ''}">
                <td>
                    ${LABELS[item]}
                </td>
                <td>
                    ${counts[item]}
                </td>
                <td>
                    ${(counts[item] / total * 100).toFixed(1)}%
                </td>
            </tr>
        `;
    }).join('');

    document.getElementById('total').textContent = total;
}

fetch('data.json').then(response => response.json()).then(showResults).catch(() => showResults(data));