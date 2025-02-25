import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
  static targets = ["dropdown", "display", "loading"];

  update() {
    const dimensionId = this.dropdownTarget.value;
    const url = `/dimension/${dimensionId}`;

    this.showLoading()

    fetch(url)
      .then(response => {
        if (!response.ok) {
          throw new Error("Network response was not ok");
        }
        return response.text(); // important: we want HTML, not JSON
      })
      .then(html => {
        // Insert the partial HTML into the display container
        this.hideLoading()
        this.displayTarget.innerHTML = html;
      })
      .catch(error => {
        this.hideLoading()
        console.error("Error fetching dimension details:", error);
        this.displayTarget.innerHTML = `<div class="alert alert-danger">Could not load dimension data.</div>`;
      });
  }

  showLoading() {
    this.loadingTarget.style.display = 'block';
    // Optionally hide the display area:
    // this.displayTarget.style.display = 'none';
  }

  hideLoading() {
    this.loadingTarget.style.display = 'none';
    // Optionally show the display area again:
    // this.displayTarget.style.display = 'block';
  }
}
