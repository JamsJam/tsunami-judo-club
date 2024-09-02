import { startStimulusApp } from '@symfony/stimulus-bundle';
import Popover from '@stimulus-components/popover'


const app = startStimulusApp();
// register any custom, 3rd party controllers here
app.register('popover', Popover);

