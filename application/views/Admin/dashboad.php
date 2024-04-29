<?php include 'includes/header.php'; ?>

<?php
if ($this->session->flashdata('welcome')) {
    echo "<h3>" . $this->session->flashdata('welcome') . "</h3>";
} ?>

<h1><?php echo "Welcome " . $this->session->userdata('fname'); ?> </h1>

<form action="" method="get">
    <label for="quiz_name">Quiz Name:</label>
    <input type="text" id="quiz_name" name="quiz_name">

    <label for="category">Category:</label>
    <select id="category" name="category">
        <option value="category1">Category 1</option>
        <option value="category2">Category 2</option>
        <option value="category3">Category 3</option>
        <option value="category1">Category 4</option>
        <option value="category2">Category 5</option>
        <option value="category3">Category 6</option>

    </select>

    <input type="submit" value="Search">
</form>

<div id="quizList"></div>

<?php include 'includes/footer.php'; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.13.1/underscore-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>
<script>
    // Backbone Model for a Quiz
    var QuizModel = Backbone.Model.extend({
        defaults: {
            quiz_title: '',
            categoryText: '',
            quizId: ''
        }
    });

    // Backbone Collection for Quizzes
    var QuizCollection = Backbone.Collection.extend({
        model: QuizModel,
        url: "<?php echo base_url('index.php/LoadQuiz/load_quizzes'); ?>"
    });

    // Backbone View for rendering each Quiz item
    var QuizView = Backbone.View.extend({
        tagName: 'div',
        template: _.template(`
            <div>
                <h3>Quiz Title: <%= quiz_title %></h3>
                <h4>Category: <%= categoryText %></h4>
                <a href="<?php echo base_url('index.php/ViewQuiz/view_quizzes/'); ?><%= quizId %>">Take Quiz</a>
            </div>
        `),
        render: function() {
            this.$el.html(this.template(this.model.toJSON()));
            return this;
        }
    });

    // Backbone View for rendering the Quiz list
    var QuizListView = Backbone.View.extend({
        el: '#quizList',
        initialize: function() {
            this.collection = new QuizCollection();
            this.listenTo(this.collection, 'sync', this.render);
            this.collection.fetch();
        },
        render: function() {
            var self = this;
            this.collection.each(function(quiz) {
                var quizView = new QuizView({
                    model: quiz
                });
                self.$el.append(quizView.render().el);
            });
            return this;
        }
    });

    // Instantiate the QuizListView
    var quizListView = new QuizListView();

    // Handle form submission
    $('#searchForm').on('submit', function(e) {
        e.preventDefault();

    });

</script>