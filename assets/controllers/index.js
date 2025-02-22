import { Application } from '@hotwired/stimulus';
import CharacterList from './character-list_controller';

const application = Application.start();
application.register('character-list', CharacterList);
