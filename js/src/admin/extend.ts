import app from 'flarum/admin/app';
import Extend from 'flarum/common/extenders';

export default [
  new Extend.Admin() //
    .setting(() => ({
      setting: 'ianm-url-cron.php-path',
      label: app.translator.trans('ianm-url-cron.admin.settings.php-path'),
      help: app.translator.trans('ianm-url-cron.admin.settings.php-path-help'),
      type: 'text',
      placeholder: '/usr/bin/php',
    })),
];
