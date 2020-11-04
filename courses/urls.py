from django.urls import path, include
from . import views
from .views import CoursesView, fransh



urlpatterns = [



    path("courses/", views.CoursesView.as_view(),name = 'courses', ),


    path("fransh/", fransh , name = 'fransh')



]