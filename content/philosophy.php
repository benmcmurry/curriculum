<div class="main">
	<div class="content-background">
		<div class="content">
        <h2>Our Curricular Philosophy</h2>
        <p>The following represent our values and beliefs regarding language teaching, learning and curriculum development. Our curricular philosophy is divided into three sections dealing with pedagogical practice, teaching specific language skills, and curricular development and change. 
        Our curricular philosophy is divided into four sections dealing with  <a href='#ppp'>pedagogical practice</a>, <a href='#skill_area'>teaching specific language skills</a>, <a href="#students">student learning</a>, and <a href='#curriculum'>curricular development and change</a>. 
        </p>
        
		
<a id='ppp'><h2>Pedagogical Practice</h2></a>
        
		
<p>ELC teachers strive to exemplify the following pedagogical practices for themselves, their students, and all who may observe their classes.</p>
<h3>1. Rely on course outcomes</h3>
<p>
Teachers understand the course outcomes for the skill and proficiency
level in which they teach and effectively communicate
them to students. They can describe student behaviors that
demonstrate these outcomes, and they successfully design classroom-learning
activities that help students progress toward
achieving them. Teachers engage in ongoing informal and formal
assessment activities and provide personalized feedback
based on the course outcomes.</p>
<h3>2. Plan lessons effectively</h3>
<p>
Teachers carefully plan lessons so language development will
be optimized during the class period. Teachers plan to incorporate
an appropriate number and variety of learning activities that
are meaningful and engaging. These activities build incrementally
from more simple uses of language to more complex uses
that are authentic and communicative. Teachers consider the
best ways to ensure that communication of explanations and
expectations are clear and concise in order to maximize student
language practice. This includes preparing the board or other
materials well ahead of class time. Teachers also prepare contingency
plans in order to adjust for a variety of unforeseen circumstances
and changing student needs.</p>
<h3>3. Optimize class time</h3>
<p>
Teachers feel a sense of urgency about using as much of the
classroom time as possible for meaningful language practice.
They convey this sense of urgency to their students by starting
class on time and by carefully managing activities and transitions
in order to maximize communicative language practice.
However, rather than rushing through their lessons, teachers
skillfully connect activities and ensure that students achieve the
needed level of mastery before moving on. They anticipate potential
threats to effective use of class time such as problems
with technology, excessive student questions, inappropriate student
behaviors and so on. Their responses to such challenges are
principled and appropriately bring the class back on course.
Teachers also end class on time.</p>
<h3>4. Cultivate a positive learning environment</h3>
<p>
Teachers understand the necessity of a positive learning environment
in order to optimize learning. They recognize that positive
teacher-student interaction is at the heart of the environment
they seek to cultivate. They foster genuine concern for their
students and their learning based on principles of respect and
trust. They leave personal concerns behind as they plan and
teach their classes. They are consistent and equitable in their
classroom practices and help students to see how classroom
policies and activities facilitate language development. They
create a non-threatening learning environment that is cheerful,
upbeat, and optimistic. They inspire students to do their best,
and they help them experience the joy of effectively applying
what they learn. They sincerely praise students and regularly
express confidence in their abilities.</p>
<h3>5. Evaluate learning effectively</h3>
<p>
Teachers are committed to the ongoing evaluation of student
learning. They skillfully use diagnostic tests, classroom instruction,
language practice, and formal and informal assessments to
clarify individual learner needs in relation to established course
outcomes. They also regularly solicit qualitative input from their
students regarding learning materials and methods. This information
is then used to make appropriate adjustments in lesson
planning and the selection of materials and methods used in the
classroom. Teachers help students to understand the rationale
for adjustments that are made as well as areas where continuity
may be necessary.</p>
<h3>6. Utilize homework strategically</h3>
<p>
Teachers understand the potential for effective homework to
help students achieve course outcomes. Rather than assigning
busy work, they carefully consider the quantity and specific
kinds of learning activities that are needed by their students in
order to foster language development or to help them better understand
and diagnose learner needs. They are able to effectively
communicate the rationale for various types of homework to
their students. They demonstrate the value of the homework in
the way they follow up and process the homework. They know
when it may be appropriate to review certain types of homework
in class and when the class time should be used for other activities.
They utilize student performance on homework to inform
their ongoing instruction in the classroom.</p>
<h3>7. Provide meaningful and timely feedback</h3>
<p>
Teachers know that feedback is essential to effective learning.
They regularly provide students with feedback that is meaningful—it
focuses on the most important language elements for
each learner; students understand the feedback, why it was given,
and how to apply it. Though teachers ensure that ongoing
feedback is timely, they are careful not to overload the students’
cognitive ability to process and apply the feedback. Along with
feedback, teachers provide students with abundant opportunities
to practice and apply the feedback in a variety of learning contexts.</p>
<h3>8. Exemplify professionalism</h3>
<p>
Teachers value and participate in orientations, training, and
workshops. They are well prepared, punctual, and complete all
administrative tasks on time. They act and look the part of a
professional in the classroom including adhering to the dress
and grooming standards and maintaining appropriate teacherstudent
boundaries. They are respectful and courteous with their
students and other teachers with whom they share resources
such as classrooms, offices, technologies, and learning materials.
They consistently evaluate their own teaching and seek to
improve through feedback from students, administrators, and
peers. They appropriately apply the relevant feedback they receive.</p>

        <a id='skill_area'><h2>Teaching Specific Language Skills</h2></a>
        <?php
        	$query = $elc_db->prepare("Select * from Skill_areas where list_order != '0'  order by list_order ASC");
            $query->execute();
            $result = $query->get_result();
           
        
            while($skill_areas = $result->fetch_assoc()){
                echo "<h3>".$skill_areas['skill_area']."</h3>";
                echo "<p>".$skill_areas['skill_area_philosophy']."</p>";
            }
        
            ?>
        <a id='students'><h2>Student Learning</h2></a>
        <p>We believe that student learning is optimized when students are:</p>
        <h3>Aware</h3>
        <p>Students know why they are studying English at the ELC. They set specific goals for their English development and prioritize their time commitments. They choose to learn the policies of the ELC and follow them, resulting in a more pleasant and productive experience. They understand their course outcomes and know what assignments are due in each class and when. They identify what they need to do in order to improve their English language skills. </p>

            <h3>Ready to Learn</h3>
        <p>Students establish beneficial patterns in their lives such as a healthy diet, getting enough water, exercise, and sleep, so they can be alert and optimize their learning. Students seek a positive and optimistic outlook and are patient with themselves and others. They also seek help when they experience mental or emotional difficulties.</p>

        <h3>Invested</h3>
        <p>Students work hard every day to improve their English. They complete their homework on time and strive to master the principles behind the homework. They are disciplined, focused, and persistent in their English study and practice. They fully participate in class. They also seek opportunities to use English whenever possible outside of class.</p>

        <h3>Strategic</h3>
        <p>Students learn about a wide variety of strategies for learning and using English effectively. They determine which strategies may work best for them in specific contexts. They identify and successfully implement those strategies that best facilitate their English language learning and use. </p>

        <h3>Evaluative</h3>
        <p>Students regularly evaluate their English language learning. They are reflective and perceptive about their progress. They understand their own strengths and weaknesses and how to access resources that may help them. They also identify challenges and make appropriate changes in their attitudes, behaviors, routines, or approaches to learning. They continually seek for and apply feedback they receive.</p>
        <a id='curriculum'><h2>Curriculum Development and Change</h2>
        

<p>We define curriculum as: all of our school-sponsored activities along with the associated materials, resources, and facilities needed to maximize meaningful student participation. This encompasses what the students are to learn and how they are to learn it, including how the teachers and the institution facilitate, assess, and respond to this learning (adapted from Rogers, 1989, p. 26).</p>
<img style='float:right' src='images/triangle.png' />
<p>All efforts associated with curriculum development and change seek an appropriate balance between three interrelated principles to ensure the curriculum is stable, responsive, and cohesive (see Figure 1). </p>
<p>Though all effective curricula must embrace some innovation, a stable curriculum implements change in a way that is orderly, systematic, and principled. For a curriculum to change in this manner and to remain viable, it must also be responsive to such factors as student needs, institutional and environmental changes, and current research. Without responsiveness, a stable curriculum soon stagnates. Finally, a sound curriculum is cohesive in that there is internal consistency and continuity between and across the various elements of the curriculum.</p>
	</div>
	</div>
</div>
