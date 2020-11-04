from django.urls import path, include
from . import views
from .views import NaoView


urlpatterns = [



    path("nao/", views.NaoView.as_view(),name = 'nao',),





]