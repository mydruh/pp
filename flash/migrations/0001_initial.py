# Generated by Django 3.1.2 on 2020-11-02 07:31

from django.db import migrations, models


class Migration(migrations.Migration):

    initial = True

    dependencies = [
    ]

    operations = [
        migrations.CreateModel(
            name='Flash',
            fields=[
                ('id', models.AutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('name', models.CharField(max_length=100, verbose_name='Название')),
                ('description', models.TextField(max_length=1000, verbose_name='Описание')),
                ('price', models.CharField(max_length=100, verbose_name='Цена')),
                ('url', models.URLField(blank=True, max_length=1000, verbose_name='Ссылка')),
            ],
            options={
                'verbose_name': 'Флешка',
                'verbose_name_plural': 'Флешки',
            },
        ),
    ]
