<?php include 'includes/header.php'; ?>

<!-- HTML code for the dashboard -->
<div class="dashboardcontainer">
    <div class="header mb-3 shadow-sm p-3 rounded-4">
        <!-- Form for searching quizzes -->
        <form action="" method="get" id="searchForm">
            <div class="row">
                <!-- Quiz Name input field -->
                <div class="col-md-4">
                    <label for="quiz_name" class="mb-1">Quiz Name:</label>
                    <input type="text" class="form-control" id="quiz_name" name="quiz_name">
                </div>

                <!-- Category select field -->
                <div class="col-md-4">
                    <label for="category" class="mb-1">Category:</label>
                    <select id="quiz_category" class="form-control" name="category">
                    </select>
                </div>

                <!-- Search button -->
                <div class="col-md-4">
                    <input type="submit" class="search fs-5 d-grid col-6 mx-auto rounded-4" value="Search">
                </div>
            </div>
        </form>
    </div>

    <!-- Container to display quizzes -->
    <div class="quizzes">
        <!-- Spinner for indicating loading -->
        <div class="spinner-grow text-secondary loadSpin" role="status" style="display:hidden;">
        </div>
        <!-- Quiz list -->
        <div id="quizList"></div>
    </div>
</div>

<!-- Include jQuery, Underscore.js, and Backbone.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.13.1/underscore-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>
<script>
    // Backbone Model for a Quiz
    var QuizModel = Backbone.Model.extend({
        defaults: {
            quiz_title: '',
            categoryText: '',
            quizId: '',
            average_rating: null
        }
    });

    // Backbone Collection for Quizzes
    var QuizCollection = Backbone.Collection.extend({
        model: QuizModel,
        url: "<?php echo base_url('index.php/LoadQuiz/load_quizzes'); ?>" // URL to fetch quizzes
    });

    // Backbone View for rendering each Quiz item
    var QuizView = Backbone.View.extend({
        tagName: 'div',
        template: _.template(`
            <div class="recent row shadow rounded-pill">
                <!-- Quiz title and category -->
                <div class="col-md-6">
                    <div><h5>Quiz Title: <%= quiz_title %></h5></div>
                    <div><h6>Category: <%= categoryText %></h6></div>
                </div>
                <!-- Button to take the quiz -->
                <div class="col-md-6 row d-flex justify-content-end">
                    <div class="col-md-5 d-flex justify-content-end align-items-center">
                        <!-- Link to take the quiz -->
                        <a href="<?php echo base_url('index.php/ViewQuiz/view_quizzes/'); ?><%= quizId %>">
                            <button class= "btn btn-primary  mx-auto" id="takequiz">Take Quiz</button>
                        </a>
                    </div>
                    <!-- Display star rating -->
                    <% if (average_rating > 0) { %>
                        <div class="col-md-6 startRatingContainer d-flex align-items-center justify-content-end">
                            <% for(var i=1; i<=average_rating; i++) { %>
                                <img height="30px" width="30px" src="<?php echo base_url('assets/images/star.png') ?>" alt="Star">
                            <% } %>
                        </div>
                    <% } else { %>
                        <!-- Display if no rating available -->
                        <div class="col-md-6 startRatingContainer d-flex align-items-center justify-content-end">
                            <h5 class="fst-italic text-secondary">No Rating</h5>
                        </div>
                    <% } %>
                </div>
            </div>
        `),
        render: function() {
            this.$el.html(this.template(this.model.toJSON())); // Render the quiz item
            return this;
        }
    });

    // Backbone View for rendering the Quiz list
    var QuizListView = Backbone.View.extend({
        el: '#quizList',
        initialize: function() {
            this.collection = new QuizCollection(); // Initialize quiz collection
            this.listenTo(this.collection, 'sync', this.render); // Listen to collection sync event
            this.showSpinner(); // Show spinner while fetching data
            this.collection.fetch(); // Fetch quiz data
        },
        render: function() {
            var self = this;
            this.collection.each(function(quiz) {
                var quizView = new QuizView({
                    model: quiz
                });
                self.$el.append(quizView.render().el); // Render each quiz item
            });
            this.hideSpinner(); // Hide spinner after rendering
            return this;
        },
        showSpinner: function() {
            $('.loadSpin').show(); // Show spinner
        },
        hideSpinner: function() {
            $('.loadSpin').hide(); // Hide spinner
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

<?php include 'includes/footer.php'; ?>
