"""django_project URL Configuration

The `urlpatterns` list routes URLs to views. For more information please see:
    https://docs.djangoproject.com/en/3.1/topics/http/urls/
Examples:
Function views
    1. Add an import:  from my_app import views
    2. Add a URL to urlpatterns:  path('', views.home, name='home')
Class-based views
    1. Add an import:  from other_app.views import Home
    2. Add a URL to urlpatterns:  path('', Home.as_view(), name='home')
Including another URLconf
    1. Import the include() function: from django.urls import include, path
    2. Add a URL to urlpatterns:  path('blog/', include('blog.urls'))
"""
from django.contrib import admin
from django.urls import path,include
from django.conf.urls.i18n import i18n_patterns

from ccg import urls
from .views import home, almaty, loading, test, team


from ccg.views import *
from courses.views import *


urlpatterns = [
    path('elab_admin/', admin.site.urls),
    path('home/' , home, name = 'home'),
    path('almaty/' , almaty, name = 'almaty'),
    path('team/' , team, name = 'team'),

    path('almaty/loading' , loading, name = 'loading'),
    path('test/' , test, name = 'test'),
    path("second/", include('ccg.urls')),


    path("", include('courses.urls')),
    path("", include('ccg.urls')),
    path("", include('courses.urls')),
    path("", include('flash.urls')),
    path("fransh/", fransh , name = "fransh"),
    path('i18n/', include('django.conf.urls.i18n')),
    path("", include('nao.urls')),







]
urlpatterns += i18n_patterns(

    path("", include('courses.urls')),

    path("", include('flash.urls')),
    path("", include('ccg.urls')),
    path("", include('courses.urls')),
    path("", include('nao.urls')),
    path("fransh/", fransh, name="fransh"),
    path('home/' , home, name = 'home'),

)
