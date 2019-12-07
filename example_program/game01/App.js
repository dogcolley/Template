window.onload = function(){
    var TurnGame = (function () {
        var instance;
        var initiate = function (heroName) {
          var hero = {
            name: heroName,
            lev: 1,
            maxHp: 100,
            hp: 100,
            xp: 0,
            att: 10
          };
          var monsters = [{
            name: '슬라임',
            hp: 25 + hero.lev * 3,
            att: 10 + hero.lev,
            xp: 10 + hero.lev,
          }, {
            name: '스켈레톤',
            hp: 50 + hero.lev * 5,
            att: 15 + hero.lev * 2,
            xp: 20 + hero.lev * 2,
          }, {
            name: '찬호[보스]',
            hp: 100 + hero.lev * 10,
            att: 25 + hero.lev * 5,
            xp: 50 + hero.lev * 5,
          }];
          var monster = null;
          var turn = true;
          return {
            showLevel: function () {
              document.getElementById('hero-level').innerHTML = hero.lev + 'lev';
              return this;
            },
            showXp: function () {
              var self = this;
              if (hero.xp > 15 * hero.lev) {
                hero.xp -= 15 * hero.lev;
                hero.maxHp += 10;
                hero.hp = hero.maxHp;
                hero.att += hero.lev;
                hero.lev++;
                window.setTimeout(function() {
                  self.setMessage('레벨업!');
                }, 1000);
              }
              document.getElementById('hero-xp').innerHTML = 'XP: ' + hero.xp + '/' + 15 * hero.lev;
              document.getElementById('hero-att').innerHTML = 'ATT: ' + hero.att;
              return this.showLevel().showHp();
            },
            showHp: function () {
              if (hero.hp < 0) {
                return this.gameOver();
              }
              document.getElementById('hero-hp').innerHTML = 'HP: ' + hero.hp + '/' + hero.maxHp;
              
              return this;
            },
            toggleMenu: function () {
              document.getElementById('hero-name').innerHTML = hero.name;
              document.getElementById('start-screen').style.display = 'none';
              if (document.getElementById('game-menu').style.display === 'block') {
                document.getElementById('game-menu').style.display = 'none';
                document.getElementById('battle-menu').style.display = 'block';
                document.getElementById('battle-input').focus();
              } else {
                document.getElementById('game-menu').style.display = 'block';
                document.getElementById('battle-menu').style.display = 'none';
                document.getElementById('menu-input').focus();
              }
              return this;
            },
            setMessage: function (msg) {
              document.getElementById('message').innerHTML = msg;
              return this;
            },
            generateMonster: function () {
              monster = JSON.parse(JSON.stringify(monsters[Math.floor(Math.random() * monsters.length)]));
              document.getElementById('monster-name').innerHTML = monster.name;
              document.getElementById('monster-hp').innerHTML = 'HP: ' + monster.hp;
              document.getElementById('monster-att').innerHTML = 'ATT: ' + monster.att;
              this.setMessage(monster.name + '이(가) 공격해옵니다');
              return this.toggleMenu();
            },
            menuInput: function (input) {
              if (input === '1') {
                return this.generateMonster();
              } else if (input === '2') {
                hero.hp = hero.maxHp;
                return this.showHp().setMessage('체력을 회복했습니다');
              } else if (input === '3') {
                return this.exit();
              } else {
                alert('잘못된 입력');
              }
            },
            battleInput: function (input) {
              if (input === '1') {
                return this.attackMonster();
              } else if (input === '2') {
                if (hero.hp + hero.lev * 20 < hero.maxHp) {
                  hero.hp += hero.lev * 20;
                } else {
                  hero.hp = hero.maxHp;
                }
                return this.showHp().setMessage('체력을 회복했습니다').nextTurn();
              } else if (input === '3') {
                return this.clearMonster().setMessage('도망쳤습니다');
              } else {
                alert('잘못된 입력');
              }
            },
            attackMonster: function () {
              monster.hp -= hero.att;
              document.getElementById('monster-hp').innerHTML = 'HP: ' + monster.hp;
              if (monster.hp > 0) {
                return this.setMessage(hero.att + '의 데미지를 입혔습니다.').nextTurn();
              }
              return this.win();
            },
            attackHero: function () {
              hero.hp -= monster.att;
              return this.showHp();
            },
            nextTurn: function () {
              var self = this;
              turn = !turn;
              document.getElementById('battle-button').disabled = true;
              if (!turn) {
                window.setTimeout(function () {
                  self.setMessage(monster.name + '의 턴입니다');
                  window.setTimeout(function () {
                    document.getElementById('battle-button').disabled = false;
                    if (self.attackHero()) {
                      self.setMessage(monster.att + '의 데미지를 입었습니다');
                      window.setTimeout(function () {
                        self.setMessage(hero.name + '의 턴입니다');
                      }, 1000);
                    }
                  }, 1000);
                }, 1000);
                return this.nextTurn();
              }
              return this;
            },
            win: function () {
              this.setMessage(monster.name + ' 사냥에 성공해 경험치 ' + monster.xp + '을 얻었습니다');
              hero.xp += monster.xp;
              return this.clearMonster().showXp();
            },
            clearMonster: function () {
              monster = null;
              document.getElementById('monster-name').innerHTML = '';
              document.getElementById('monster-hp').innerHTML = '';
              document.getElementById('monster-att').innerHTML = '';
              return this.toggleMenu();
            },
            gameOver: function () {
              document.getElementById('screen').innerHTML = hero.name + '은 레벨' + hero.lev + '에서 죽었습니다. 새로 시작하려면 새로고침하세요';
              return false;
            },
            exit: function (input) {
              document.getElementById('screen').innerHTML = '이용해주셔서 감사합니다. 새로 시작하려면 새로고침하세요';
            }
          };
        };
        return {
          getInstance: function (name) {
            if (!instance) {
              instance = initiate(name);
            }
            return instance;
          }
        };
      })();
      document.getElementById('start-screen').onsubmit = function (e) {
        var name = document.getElementById('name-input').value;
        e.preventDefault();
        if (name && name.trim() && confirm(name + '으로 하시겠습니까?')) {
          TurnGame.getInstance(name).showXp().toggleMenu();
        } else {
          alert('이름을 입력해주세요');
        }
      };
      document.getElementById('game-menu').onsubmit = function (e) {
        var input = document.getElementById('menu-input');
        var option = input.value;
        e.preventDefault();
        input.value = '';
        TurnGame.getInstance().menuInput(option);
      };
      document.getElementById('battle-menu').onsubmit = function (e) {
        var input = document.getElementById('battle-input');
        var option = input.value;
        e.preventDefault();
        input.value = '';
        TurnGame.getInstance().battleInput(option);
      };
};
