<?php include 'includes/header.php'; ?>

<div class="dashboardcontainer">
    <div class="header mb-3 shadow-sm p-3 rounded-4">
        <form action="" method="get">
            <div class="row">
                <div class="col-md-4">
                    <label for="quiz_name" class="mb-1">Quiz Name:</label>
                    <input type="text" class="form-control" id="quiz_name" name="quiz_name">
                </div>

                <div class="col-md-4">
                    <label for="category" class="mb-1">Category:</label>
                    <select id="quiz_category" class="form-control" name="category">
                    </select>
                </div>

                <div class="col-md-4">
                    <input type="submit" class="search fs-5 d-grid col-6 mx-auto rounded-4" value="Search">
                </div>
            </div>
        </form>
    </div>
    <div class="quizzes">
        <div id="quizList"></div>
    </div>
</div>

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
            <div class="recent row shadow rounded-pill">
                <div class="col-md-9">
                    <div><h5>Quiz Title: <%= quiz_title %></h5></div>
                    <div><h6>Category: <%= categoryText %></h6></div>
                </div>
                <div class="col-md-3 my-auto"><a href="<?php echo base_url('index.php/ViewQuiz/view_quizzes/'); ?><%= quizId %>"><button class= "btn btn-primary  mx-auto" id="takequiz">Take Quiz</button></a></div>
            </div>
        `),
        render: function() {
            this.$el.html(this.template(this.model.toJSON()));
            return this;
        }
    });

    // <div class = "col-md-6"><h5>Quiz Title: <%= quiz_title %></h5></div>
    //                 <div class = "col-md-4"> <h6>Category: <%= categoryText %></h6></div>

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
        // Your form submission logic here
    });
</script>