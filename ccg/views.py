from .models import Courses
from django.shortcuts import render , redirect
from django.views.generic.base import View

from django.http import HttpResponse



# Create your views here.
"""
class ContentView(View):
    def post(self, request):
        form = ContentForm(request.POST)
        form.save()


        return redirect("form/")

        return render(request, 'courses_list.html')


"""

class CoursesView(View):
    def get(self,request):
        courses = Courses.objects.all()
        return render(request, "courses_almaty.html", {"courses_list": courses})







