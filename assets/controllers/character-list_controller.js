import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
  static targets = ['select', 'list'];
  static values = {
    loadingMessage: { type: String, default: 'Loading characters...' },
    errorMessage: { type: String, default: 'Error loading characters.' }
  };

  async onChange(event) {
    const dimensionId = event.target.value;

    if (!dimensionId) {
      this.clearList();
      return;
    }

    await this.fetchAndDisplayCharacters(dimensionId);
  }

  async fetchAndDisplayCharacters(dimensionId) {
    this.showLoading();
    console.log('hello');

    try {
      const response = await fetch(`/dimension/${dimensionId}/characters`);
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }

      const data = await response.json();
      this.renderCharacters(data);
    } catch (error) {
      console.error('Error:', error);
      this.showError();
    }
  }

  renderCharacters(data) {
    const template = `
            <div class="dimension-info">
                <h2 class="text-xl font-bold mb-2">${data.name} (${data.dimension})</h2>
                <p class="text-gray-600 mb-4">Type: ${data.type}</p>
            </div>

            <div class="residents">
                <h3 class="text-lg font-semibold mb-2">Residents:</h3>
                <ul class="space-y-2">
                    ${data.residents.map(character => `
                        <li class="p-3 bg-gray-50 rounded-lg shadow-sm">
                            <span class="font-medium">${character.name}</span>
                            <span class="text-gray-500">(${character.species})</span>
                        </li>
                    `).join('')}
                </ul>
            </div>
        `;

    this.listTarget.innerHTML = template;
  }

  showLoading() {
    this.listTarget.innerHTML = `
            <div class="loading py-4 text-center text-gray-600">
                ${this.loadingMessageValue}
            </div>
        `;
  }

  showError() {
    this.listTarget.innerHTML = `
            <div class="error-message p-4 bg-red-100 text-red-700 rounded-lg">
                ${this.errorMessageValue}
            </div>
        `;
  }

  clearList() {
    this.listTarget.innerHTML = '';
  }
}
