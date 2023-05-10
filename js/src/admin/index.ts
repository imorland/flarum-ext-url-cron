import app from 'flarum/admin/app';

app.initializers.add('ianm-url-cron', () => {
  app.extensionData.for('ianm-url-cron').registerSetting({
    setting: 'ianm-url-cron.php-path',
    label: app.translator.trans('ianm-url-cron.admin.settings.php-path'),
    help: app.translator.trans('ianm-url-cron.admin.settings.php-path-help'),
    type: 'text',
    placeholder: '/usr/bin/php',
  });
});
