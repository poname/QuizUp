<div id="header">
    {% include "include/header.volt" %}
</div>


<div class="ui stripe community vertical segment"><a class="item">
    </a>
    <div class="ui red two column center aligned divided very relaxed stackable grid container">
        <div class="row">
			<div class="column">
                <div class="ui middle aligned center aligned grid">
                    <div class="column">
						<table class="ui inverted blue table">
							<thead>
							<tr>
								<th>{{t('NAME')}}</th>
								<th>{{t('FAMILY_NAME')}}</th>
								<th>{{t('POINTS')}}</th>
							</tr>
							</thead>
							<tbody>
							{% for user in rankings %}
								<tr>
									<td>{{ user.name }}</td>
									<td>{{ user.family }}</td>
									<td>{{ user.points }}</td>
								</tr>
							{% endfor %}
							</tbody>

						</table>
						<button class="fluid ui red button" id='moreRanks' onclick="location.href='{{ url('ranking/more') }}';"><p>{{t('MORE')}}</p></button>
					</div>
				</div>
			</div>
            <div class="column"><a class="item">
                </a>
                <div class="ui red segment">
                    <h2 class="ui icon header fa">{{ t('READY_TO_START?') }}</h2>
                    <p>{{ t('START_A_QUIZ_NOW') }}</p>
                    <div class="ui divider"></div>
                    <a class="ui red button fa" href="{{ url('quiz/selectCategory') }}">{{ t('START') }}</a>
                </div>
                <div class="ui segment">
                    <h2 class="ui icon header">
                        <p>{{ t('MANAGE_CATEGORY') }}</p>
                    </h2>
                    <p></p>
                    <a class="ui violet large basic button button" href="{{ url('category/create') }}"><p>{{ t('CREATE_CATEGORY') }}</p>
                    </a>
                    <a class="ui green large basic button button" href="{{ url('category/list') }}"><p>{{ t('CATEGORIES') }}</p></a>
                </div>
                <div class="ui segment">
                    <h2 class="ui icon header">
                        <p>{{ t('MANAGE_QUESTIONS') }}</p>
                    </h2>
                    <p></p>
                    <a class="ui pink large basic button button" href="{{ url('question/create') }}"><p>{{ t('CREATE_QUESTION') }}</p></a>
                    <a class="ui brown large basic button button" href="{{ url('question/list') }}"><p>{{ t('QUESTIONS') }}</p></a>
                </div>
                <div class="ui segment">
                    <h2 class="ui icon header">
                        <p>{{ t('RANKINGS') }}</p>
                    </h2>
                    <p></p>
                    <a class="ui blue large basic button button" href="{{ url('ranking/index') }}"><p>{{ t('SEE_BEST_RANKINGS') }}</p></a>

                </div>
            </div>
			
        </div>
        <div id="footer">
            {% include "include/footer.volt" %}
        </div>
    </div>


</div>